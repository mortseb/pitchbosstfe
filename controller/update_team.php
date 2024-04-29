<?php
session_start();

// Récupérer les données POST
$ownerid = $_SESSION['user_id'];
$playerid = $_POST['playerid'];
$position = $_POST['position'];
require __DIR__ . '/vendor/autoload.php';

// Load environment variables from .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Connexion à la base de données
$db_host = $_ENV['DB_HOST'];
$db_name = $_ENV['DB_NAME'];
$db_user = $_ENV['DB_USER'];
$db_pass = $_ENV['DB_PASS'];

$db = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);


// Préparer la requête SQL pour mettre à jour l'équipe
$stmt = $db->prepare("
    UPDATE team 
    SET $position = :playerid 
    WHERE ownerid = :ownerid
");

// Exécuter la requête SQL pour mettre à jour l'équipe
$stmt->execute([
    ':ownerid' => $ownerid,
    ':playerid' => $playerid,
]);

// Préparer la requête SQL pour mettre à jour la table "players"
$stmtPlayers = $db->prepare("
    UPDATE players 
    SET position = :position 
    WHERE id = :playerid
");

// Exécuter la requête SQL pour mettre à jour la table "players"
$stmtPlayers->execute([
    ':position' => $position,
    ':playerid' => $playerid,
]);

// Préparer la requête SQL pour obtenir l'id de l'équipe
$stmtTeam = $db->prepare("
    SELECT id
    FROM team
    WHERE ownerid = :ownerid
");

// Exécuter la requête SQL pour obtenir l'id de l'équipe
$stmtTeam->execute([
    ':ownerid' => $ownerid
]);

// Récupérer l'id de l'équipe
$teamId = $stmtTeam->fetchColumn();

// Utiliser le $teamId pour les requêtes suivantes au lieu du $ownerid

// Préparer la requête SQL pour vérifier si toutes les positions de l'équipe sont remplies
$stmtCheck = $db->prepare("
    SELECT *
    FROM team
    WHERE id = :teamId AND gk1 <> 0 AND def1 <> 0 AND def2 <> 0 AND def3 <> 0 AND def4 <> 0 AND mid1 <> 0 AND mid2 <> 0 AND mid3 <> 0 AND atk1 <> 0 AND atk2 <> 0 AND atk3 <> 0
");

// Exécuter la requête SQL pour vérifier si toutes les positions de l'équipe sont remplies
$stmtCheck->execute([
    ':teamId' => $teamId
]);

// Préparer la requête SQL pour vérifier si l'équipe existe déjà dans la table "team_season_result"
$stmtExists = $db->prepare("
    SELECT *
    FROM team_season_result
    WHERE teamid = :teamId
");

// Exécuter la requête SQL pour vérifier si l'équipe existe déjà dans la table "team_season_result"
$stmtExists->execute([
    ':teamId' => $teamId
]);

// Si toutes les positions de l'équipe sont remplies et que l'équipe n'existe pas déjà dans la table "team_season_result",
// insérer l'équipe dans la table "team_season_result"
if ($stmtCheck->fetch() && !$stmtExists->fetch()) {
    $stmtInsert = $db->prepare("
        INSERT INTO team_season_result (teamid)
        VALUES (:teamId)
    ");
    $stmtInsert->execute([
        ':teamId' => $teamId
    ]);
}
