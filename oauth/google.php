<?php
session_start();

function getBaseUrl() {
    return 'http://localhost:8000';
}

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../includes/functions.php';

$clientID = '135683396682-8b7j9pe5perpsvsa89m99o32m75urriu.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = getBaseUrl() . '/oauth/google.php';

$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

    if (!isset($token['error'])) {
        $client->setAccessToken($token['access_token']);

        $google_service = new Google_Service_Oauth2($client);
        $userData = $google_service->userinfo->get();

        $id = htmlspecialchars($userData->id, ENT_QUOTES, 'UTF-8');
        $name = htmlspecialchars($userData->name, ENT_QUOTES, 'UTF-8');
        $email = htmlspecialchars($userData->email, ENT_QUOTES, 'UTF-8');
        $picture = htmlspecialchars($userData->picture, ENT_QUOTES, 'UTF-8');
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <title>Connexion...</title>
        </head>
        <body>
        <script>
            const user = {
                provider: 'google',
                oauth_uid: "<?= $id ?>",
                name: "<?= $name ?>",
                email: "<?= $email ?>",
                picture: "<?= $picture ?>"
            };

            fetch('<?= getBaseUrl() ?>/ajax/connect-h.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(user)
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    window.location.href = '<?= getBaseUrl() ?>/dashboard.php';
                } else {
                    alert('Erreur : ' + data.message);
                    window.location.href = '<?= getBaseUrl() ?>/index.php';
                }
            })
            .catch(error => {
                alert('Erreur réseau : ' + error.message);
                window.location.href = '<?= getBaseUrl() ?>/index.php';
            });
        </script>
        </body>
        </html>
        <?php
        exit;
    } else {
        header('Location: ' . getBaseUrl() . '/index.php?error=token_error');
        exit;
    }
}

$authUrl = $client->createAuthUrl();
header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
exit;
