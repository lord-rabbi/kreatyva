<?php
session_start();
require_once '../includes/db.php';

require_once __DIR__ . '/../vendor/autoload.php'; 

$fb = new \Facebook\Facebook([
    'app_id' => '740530945362146',
    'app_secret' => '3632e9e491919e659cab39cd0c9c147c',
    'default_graph_version' => 'v17.0',
]);

$helper = $fb->getRedirectLoginHelper();

try {
    $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
    exit('Erreur Graph: ' . $e->getMessage());
} catch(Facebook\Exceptions\FacebookSDKException $e) {
    exit('Erreur SDK: ' . $e->getMessage());
}

if (!isset($accessToken)) {
    header('Location: ../index.php');
    exit;
}

try {
    $response = $fb->get('/me?fields=id,name,email,picture.type(large)', $accessToken);
    $userNode = $response->getGraphUser();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
    exit('Erreur Graph: ' . $e->getMessage());
} catch(Facebook\Exceptions\FacebookSDKException $e) {
    exit('Erreur SDK: ' . $e->getMessage());
}

$userData = [
    'oauth_uid' => $userNode->getId(),
    'name' => $userNode->getName(),
    'email' => $userNode->getEmail(),
    'provider' => 'facebook',
    'picture' => $userNode->getPicture()->getUrl()
];

$ch = curl_init('http://localhost:8000/api/oauth_login.php');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($userData));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, true);
if ($result['success']) {
    header('Location: ../dashboard.php');
    exit;
} else {
    echo 'Erreur de connexion.';
}
