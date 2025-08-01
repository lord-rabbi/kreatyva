<?php
session_start();
require_once '../includes/db.php';

header('Content-Type: application/json');

// Vérifie que la connexion PDO existe
if (!isset($pdo)) {
    // Tu dois t'assurer que ton fichier db.php crée une variable $pdo
    echo json_encode(['success' => false, 'message' => 'Connexion à la base de données non établie']);
    exit;
}

// Récupérer les données JSON POST
$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['email'], $data['name'], $data['provider'], $data['oauth_uid'])) {
    echo json_encode(['success' => false, 'message' => 'Données invalides']);
    exit;
}

$email = $data['email'];
$name = $data['name'];
$provider = $data['provider'];
$oauth_uid = $data['oauth_uid'];
$picture = $data['picture'] ?? null;

try {
    // Vérifier si l'utilisateur existe déjà
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Connexion d'un utilisateur existant
        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'picture' => $user['picture']
        ];
        echo json_encode(['success' => true]);
    } else {
        // Création d’un nouvel utilisateur
        $insert = $pdo->prepare("INSERT INTO users (oauth_provider, oauth_uid, name, email, picture) VALUES (:provider, :uid, :name, :email, :picture)");
        $insert->execute([
            'provider' => $provider,
            'uid' => $oauth_uid,
            'name' => $name,
            'email' => $email,
            'picture' => $picture
        ]);
        $user_id = $pdo->lastInsertId();

        $_SESSION['user'] = [
            'id' => $user_id,
            'name' => $name,
            'email' => $email,
            'picture' => $picture
        ];
        echo json_encode(['success' => true]);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur SQL : ' . $e->getMessage()]);
}
