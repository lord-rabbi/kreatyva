<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

$user = $_SESSION['user'];

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Dashboard - Kreatyva</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet" />
    <style>
        body {
            background-color: #000000;
            color: #f6f2e6;
            font-family: 'Quicksand', sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }

        .dashboard-card {
            background-color: #1a1a1a;
            padding: 2rem 3rem;
            border-radius: 1rem;
            box-shadow: 0 0 20px rgba(228, 185, 91, 0.3);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        .dashboard-card h2 {
            margin-bottom: 1rem;
            color: #e4b95b;
        }

        .dashboard-card p {
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }

        .profile-pic {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e4b95b;
            margin-bottom: 1.5rem;
        }

        .btn-logout {
            display: inline-block;
            background-color: #e4b95b;
            color: #000;
            padding: 10px 25px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-logout:hover {
            background-color: #d9a741;
            transform: scale(1.05);
            color: #000;
        }
    </style>
</head>
<body>
    <div class="dashboard-card">
        
        <h2>Bienvenue, <?= htmlspecialchars($user['name']) ?></h2>
        <img src="<?= htmlspecialchars($user['picture']) ?>"class="profile-pic" />
        <p><strong>Email :</strong> <?= htmlspecialchars($user['email']) ?></p>
        <a href="deconnexion.php" class="btn-logout">Déconnexion</a>
    </div>
</body>
</html>
