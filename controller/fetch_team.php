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

$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

$ownerid = $_SESSION['user_id'];
$results = [];

$query = $mysqli->query("SELECT gk1, def1, def2, def3, def4, mid1, mid2, mid3, atk1, atk2, atk3 FROM team WHERE ownerid = $ownerid");

while ($row = $query->fetch_assoc()) {
    foreach ($row as $position => $playerId) {
        if ($playerId) {
            $playerQuery = $mysqli->query("SELECT * FROM players WHERE id = $playerId");
            $playerInfo = $playerQuery->fetch_assoc();
            $results[] = ['player' => $playerInfo, 'position' => $position];
        }
    }
}

// Get averages from a different table or field
$averagesQuery = $mysqli->query("SELECT avgGK, avgDEF, avgMID, avgATK, avgTotalScore FROM team WHERE ownerid = $ownerid");
$averages = $averagesQuery->fetch_assoc();
$results[] = ['averages' => $averages];

echo json_encode($results);

?>
