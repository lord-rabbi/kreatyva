<?php
session_start();
if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit();
}
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

.google-btn {
    display: inline-block;
    width: 100%;
    background-color: #e4b95b;
    color: #000000;
    padding: 10px 0;
    text-align: center;
    text-decoration: none;
    font-weight: bold;
    border-radius: 5px;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.google-btn:hover {
    background-color: #d9a741;
    transform: scale(1.02);
    color: #000000;
}

    </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">

    <div class="login-card text-center">
        <h2 class="mb-4">Connexion à <strong>Kreatyva</strong></h2>
        <div id="login-buttons">
            <a href="oauth/google.php" class="google-btn">Se connecter avec Google</a>
        </div>
    </div>

</body>
</html>
