<?php
session_start();
require __DIR__ . '/vendor/autoload.php';

// Load environment variables from .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Connexion à la base de données
$db_host = $_ENV['DB_HOST'];
$db_name = $_ENV['DB_NAME'];
$db_user = $_ENV['DB_USER'];
$db_pass = $_ENV['DB_PASS'];

$db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
$username = $_SESSION['username'];

// Récupération de l'ID de l'utilisateur
$query = $db->prepare("SELECT id FROM users WHERE username = ?");
$query->execute([$username]);
$user = $query->fetch();
$userId = $user['id'];
$type = $_GET['type'];

// Définition des valeurs par défaut pour le nombre de joueurs et le coût
$players = 0;
$cost = 0;

// Assignation des valeurs correspondantes en fonction du type de pack
switch ($type) {
    case 'gold':
        $players = 23;
        $cost = 4000;
        break;
    case 'silver':
        $players = 11;
        $cost = 2000;
        break;
    case 'bronze':
        $players = 5;
        $cost = 1000;
        break;
}

// Récupération des crédits de l'utilisateur
$query = $db->prepare("SELECT credits FROM users WHERE id = ?");
$query->execute([$userId]);
$user = $query->fetch();

// Vérification que l'utilisateur a suffisamment de crédits
if ($user['credits'] < $cost) {
    header('Location: ../view/buy_packs.php?error=not_enough_credits');
    exit();
}

// Déduction des crédits de l'utilisateur
$query = $db->prepare("UPDATE users SET credits = credits - ? WHERE id = ?");
$query->execute([$cost, $userId]);

// Insertion du nouveau pack dans la base de données
$query = $db->prepare("INSERT INTO packs (type, nbjoueurs, ownerid) VALUES (?, ?, ?)");
$query->execute([$type, $players, $userId]);

// Redirection vers la page de packs
header('Location: ../view/buy_packs.php');
?>