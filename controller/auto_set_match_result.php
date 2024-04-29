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

$faker = Faker\Factory::create();
// 1. Récupérer le prochain match pour chaque équipe unique
$teams = $db->query("SELECT * FROM team WHERE nextmatch IN (SELECT DISTINCT nextmatch FROM team) AND id IN (SELECT DISTINCT teamid FROM team_season_result) AND id IN (SELECT teamA FROM calendrier WHERE id = nextmatch)")->fetchAll(PDO::FETCH_ASSOC);

foreach ($teams as $team) {
    // Si nextmatch est 0, sauter cette équipe
    if ($team['nextmatch'] == 0) {
        continue;
    }
    // Chercher les informations des deux équipes pour chaque match.
    $nextMatchId = $team['nextmatch'];
    $nextMatch = $db->query("SELECT * FROM calendrier WHERE id = $nextMatchId")->fetch(PDO::FETCH_ASSOC);

    $teamA = $db->query("SELECT * FROM team WHERE id = {$nextMatch['teamA']}")->fetch(PDO::FETCH_ASSOC);
    $teamB = $db->query("SELECT * FROM team WHERE id = {$nextMatch['teamB']}")->fetch(PDO::FETCH_ASSOC);

    //Calcul du résultat

    //Domination calculée en fonction de la note globale
    
    $dominationA = ($teamA['avgTotalScore'] * 100) / ($teamA['avgTotalScore'] + $teamB['avgTotalScore']) ;
    $dominationB = 100 - $dominationA;

    $occasionA = max(0, round(30*$dominationA/100 * $teamA['avgMID'] /$teamB['avgMID'] + rand(-5, 5)));
    $occasionB = max(0, round(30*$dominationB/100 * $teamB['avgMID'] / $teamA['avgMID'] + rand(-5, 5)));

    $tirA = max(0, round($occasionA * ((rand(30, 80) / 100) + 0.02 * ($teamA['avgATK'] - $teamB['avgDEF']))));
    $tirB = max(0, round($occasionB * ((rand(30, 80) / 100) + 0.02 * ($teamB['avgATK'] - $teamA['avgDEF']))));

    $scoreA = max(0, round($tirA * ((rand(0, 40) / 100) + 0.02 * ($teamA['avgATK'] - $teamB['avgGK']))));
    $scoreB = max(0, round($tirB * ((rand(0, 40) / 100) + 0.02 * ($teamB['avgATK'] - $teamA['avgGK']))));

    // Mettre à jour le calendrier avec les résultats du match
    $update = $db->prepare("UPDATE calendrier SET dominationA = ?, dominationB = ?, occasionA = ?, occasionB = ?, tirA = ?, tirB = ?, scoreA = ?, scoreB = ? WHERE id = ?");
    $update->execute([$dominationA, $dominationB, $occasionA, $occasionB, $tirA, $tirB, $scoreA, $scoreB, $nextMatchId]);

    // Mettre à jour les stats de chaque équipe dans la table team_season_result
    $matchteams = [$teamA, $teamB];
    foreach ($matchteams as $team) {
        // Calculer les résultats du match
        $scored = $team == $teamA ? $scoreA : $scoreB;
        $conceded = $team == $teamA ? $scoreB : $scoreA;
        $win = $scored > $conceded ? 1 : 0;
        $draw = $scored == $conceded ? 1 : 0;
        $lose = $scored < $conceded ? 1 : 0;

        // Mettre à jour les statistiques de l'équipe
        $update = $db->prepare("UPDATE team_season_result SET win = win + ?, draw = draw + ?, lose = lose + ?, scored = scored + ?, conceded = conceded + ? WHERE teamid = ?");
        $update->execute([$win, $draw, $lose, $scored, $conceded, $team['id']]);

        // Mettre à jour les points de l'équipe
        $db->exec("UPDATE team_season_result SET points = win * 3 + draw WHERE teamid = {$team['id']}");



$creditsToAdd = 40 * $team['avgTotalScore'];

// Prépare la requête SQL
$update = $db->prepare("UPDATE users SET credits = credits + ? WHERE id = (SELECT ownerid FROM team WHERE id = ?)");

// Exécute la requête en utilisant la nouvelle valeur de credits
$update->execute([$creditsToAdd, $team['id']]);

    }
}
// Générer de nouveaux matchs
function generateNewMatches($db) {
    // Obtenir uniquement les équipes qui sont enregistrées dans team_season_result
    $teams = $db->query("SELECT * FROM team WHERE id IN (SELECT DISTINCT teamid FROM team_season_result)")->fetchAll(PDO::FETCH_ASSOC);

    // Mélanger les équipes
    shuffle($teams);

    // Si le nombre d'équipes est impair, ajouter l'équipe avec l'id 4
    if (count($teams) % 2 != 0) {
        $team4 = $db->query("SELECT * FROM team WHERE id = 4")->fetch(PDO::FETCH_ASSOC);
        $teams[] = $team4;
    }

    // Diviser les équipes en paires et les insérer dans la table calendrier
    for ($i = 0; $i < count($teams); $i += 2) {
        $teamA = $teams[$i];
        $teamB = $teams[$i + 1];
        $db->exec("INSERT INTO calendrier (teamA, teamB) VALUES ({$teamA['id']}, {$teamB['id']})");

        // Récupérer l'id du match que nous venons d'insérer
        $matchId = $db->lastInsertId();

        // Mettre à jour le nextmatch pour les deux équipes
        $db->exec("UPDATE team SET nextmatch = $matchId WHERE id = {$teamA['id']} OR id = {$teamB['id']}");
    }

    // Si l'équipe avec l'id 4 n'a pas été utilisée, réinitialiser son nextmatch
    if (!in_array(4, array_column($teams, 'id'))) {
        $db->exec("UPDATE team SET nextmatch = 0 WHERE id = 4");
    }
}


$teams = $db->query("SELECT * FROM team WHERE id != 4")->fetchAll(PDO::FETCH_ASSOC);
generateNewMatches($db);
// Updating the 'date' and 'nextnat' columns in the 'next_match' table
$next_date = date('Y-m-d', strtotime('+1 day'));
$next_nat = $faker->countryCode;

$update = $db->prepare("UPDATE next_match SET date = ?, nextnat = ?");
$update->execute([$next_date, $next_nat]);
// Fin de votre script
