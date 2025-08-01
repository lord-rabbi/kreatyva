<?php
error_reporting(E_ALL & ~E_DEPRECATED);

session_start();
if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit();
}

require_once __DIR__ . '/vendor/autoload.php';

$fb = new \Facebook\Facebook([
    'app_id' => '740530945362146',
    'app_secret' => '3632e9e491919e659cab39cd0c9c147c',
    'default_graph_version' => 'v17.0',
]);

$helper = $fb->getRedirectLoginHelper();
$permissions = ['email']; 
$facebookLoginUrl = $helper->getLoginUrl('http://localhost:8000/oauth/facebook.php', $permissions);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion Kreatyva</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css"> 
    <style>
        body {
            background-color: #000000;
            color: #f6f2e6;           
            font-family: 'Quicksand', sans-serif;
        }

        .login-card {
            max-width: 400px;
            padding: 2rem;
            background-color: #1a1a1a; 
            border-radius: 1rem;
            box-shadow: 0 0 20px rgba(228, 185, 91, 0.2);
        }

        .login-card h2 {
            color: #f6f2e6;
        }

        .btn-oauth {
            display: inline-block;
            width: 100%;
            padding: 10px 0;
            text-align: center;
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.2s ease;
            margin-bottom: 10px;
        }

        .google-btn {
            background-color: #e4b95b;
            color: #000000;
        }

        .google-btn:hover {
            background-color: #d9a741;
            transform: scale(1.02);
        }

        .facebook-btn {
            background-color: #4267B2;
            color: white;
        }

        .facebook-btn:hover {
            background-color: #365899;
            transform: scale(1.02);
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">

    <div class="login-card text-center">
        <h2 class="mb-4">Connexion à <strong>Kreatyva</strong></h2>
        <div id="login-buttons">
            <a href="oauth/google.php" class="btn-oauth google-btn">Se connecter avec Google</a>
            <a href="<?= htmlspecialchars($facebookLoginUrl) ?>" class="btn-oauth facebook-btn">Se connecter avec Facebook</a>
        </div>
    </div>

</body>
</html>
