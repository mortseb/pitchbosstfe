<?php
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

// Assurez-vous que les erreurs sont signalées
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Préparez une requête pour obtenir la date du prochain match
$stmt = $db->prepare("SELECT `date` FROM `next_match` ORDER BY `date` ASC LIMIT 1");

// Exécutez la requête
$stmt->execute();

// Récupérez le résultat
$result = $stmt->fetch(PDO::FETCH_ASSOC);

// Vérifiez si un résultat a été obtenu
if ($result) {
    // Stockez la date du prochain match dans une variable
    $nextMatchDate = $result['date'];
} else {
    // Si aucune date de match n'est disponible, définissez un message par défaut
    $nextMatchDate = "Pas de match prévu";
}
?>