<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../controller/getUserInfo.php');


// Load environment variables from .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Connexion à la base de données
$db_host = $_ENV['DB_HOST'];
$db_name = $_ENV['DB_NAME'];
$db_user = $_ENV['DB_USER'];
$db_pass = $_ENV['DB_PASS'];

try {
    $db = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}


if (isset($_GET['numberOfPlayers'])) {
    $numberOfPlayers = $_GET['numberOfPlayers'];

    // Récupérer les derniers joueurs générés
    $stmt = $db->prepare("SELECT * FROM players WHERE ownerid = ? ORDER BY id DESC LIMIT ?");
    $stmt->bindValue(1, $user['id'], PDO::PARAM_INT);
    $stmt->bindValue(2, (int)$numberOfPlayers, PDO::PARAM_INT);
    $stmt->execute();
    $players = $stmt->fetchAll(PDO::FETCH_ASSOC);

} else {
    // Rediriger si le nombre de joueurs n'est pas spécifié
    header('Location: ../view/open_packs.php');
    exit();
}
