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

// Fetch all players owned by the current user
$stmt = $db->prepare("SELECT * FROM players WHERE ownerid = ? ORDER BY id DESC");
$stmt->bindValue(1, $user['id'], PDO::PARAM_INT);
$stmt->execute();
$players = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt2 = $db->prepare("SELECT gk1, def1, def2, def3, def4, mid1, mid2, mid3, atk1, atk2, atk3 FROM team WHERE ownerid = ?");
$stmt2->bindValue(1, $user['id'], PDO::PARAM_INT);
$stmt2->execute();
$team = $stmt2->fetchAll(PDO::FETCH_ASSOC);

// Get next match nationality
$stmt3 = $db->prepare("SELECT nextnat FROM next_match LIMIT 1");
$stmt3->execute();
$next_match_nationality = $stmt3->fetchColumn();
?>
