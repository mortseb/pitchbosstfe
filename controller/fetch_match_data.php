<?php
require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$db_host = $_ENV['DB_HOST'];
$db_name = $_ENV['DB_NAME'];
$db_user = $_ENV['DB_USER'];
$db_pass = $_ENV['DB_PASS'];

try {
    $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    // set the PDO error mode to exception
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Récupérer l'id de l'utilisateur de la session
$userId = $_SESSION['user_id'];

// Trouver l'équipe de l'utilisateur
$teamStmt = $db->prepare("
    SELECT * FROM team WHERE ownerid = :ownerid
");
$teamStmt->execute(['ownerid' => $userId]);
$userTeam = $teamStmt->fetch(PDO::FETCH_ASSOC);

$userTeamId = $userTeam['id'];

// Trouver le prochain match de l'utilisateur
$matchStmt = $db->prepare("
    SELECT * FROM calendrier 
    WHERE (teamA = :team_id OR teamB = :team_id) 
    AND dominationA = 0 AND dominationB = 0
    ORDER BY id ASC
    LIMIT 1
");

$matchStmt->execute(['team_id' => $userTeamId]);
$nextMatch = $matchStmt->fetch(PDO::FETCH_ASSOC);

$teamAId = $nextMatch['teamA'];
$teamBId = $nextMatch['teamB'];

// Récupérer les informations des équipes
$teamA = fetchTeamInfo($db, $teamAId);
$teamB = fetchTeamInfo($db, $teamBId);
// Fetch last matches for both teams
$lastMatchesA = fetchLastMatches($db, $teamAId);
$lastMatchesB = fetchLastMatches($db, $teamBId);





// Helper function to fetch team info
function fetchTeamInfo($db, $teamId) {
    $teamStmt = $db->prepare("
        SELECT * FROM team WHERE id = :id
    ");
    $teamStmt->execute(['id' => $teamId]);
    $team = $teamStmt->fetch(PDO::FETCH_ASSOC);
   
    $ownerId = $team['ownerid'];
    // Fetch owner info
    $userStmt = $db->prepare("
        SELECT * FROM users WHERE id = :id
    ");
    $userStmt->execute(['id' => $ownerId]);
    $user = $userStmt->fetch(PDO::FETCH_ASSOC);
    
    $teamName = $user['team'];
   // Fetch player info
$positions = ['gk1', 'def1', 'def2', 'def3', 'def4', 'mid1', 'mid2', 'mid3', 'atk1', 'atk2', 'atk3'];
$players = [];
foreach ($positions as $position) {
    $playerId = $team[$position];
    $playerStmt = $db->prepare("
        SELECT * FROM players WHERE id = :id
    ");
    $playerStmt->execute(['id' => $playerId]);
    $player = $playerStmt->fetch(PDO::FETCH_ASSOC);

    // Add the position as a key in the player array
    $player['position'] = $position;
    $players[] = $player;
}

    return [
        'team_name' => $teamName,
        'avgGK' => $team['avgGK'],
        'avgDEF' => $team['avgDEF'],
        'avgMID' => $team['avgMID'],
        'avgATK' => $team['avgATK'],
        'avgTotalScore' => $team['avgTotalScore'],
        'players' => $players,
    ];
}
// Helper function to fetch last matches
function fetchLastMatches($db, $teamId) {
    $matchStmt = $db->prepare("
        SELECT * FROM calendrier 
        WHERE (teamA = :team_id OR teamB = :team_id) AND (dominationA != 0 OR dominationB != 0)
        ORDER BY id DESC
        LIMIT 5
    ");

    $matchStmt->execute(['team_id' => $teamId]);
    $matches = $matchStmt->fetchAll(PDO::FETCH_ASSOC);

    return $matches;
}
function getMatchTeamNames($db, $match) {
    $teamAStmt = $db->prepare("
        SELECT users.team FROM users INNER JOIN team ON users.id = team.ownerid WHERE team.id = :id
    ");
    $teamAStmt->execute(['id' => $match['teamA']]);
    $teamAName = $teamAStmt->fetch(PDO::FETCH_ASSOC);

    $teamBStmt = $db->prepare("
        SELECT users.team FROM users INNER JOIN team ON users.id = team.ownerid WHERE team.id = :id
    ");
    $teamBStmt->execute(['id' => $match['teamB']]);
    $teamBName = $teamBStmt->fetch(PDO::FETCH_ASSOC);

    return [$teamAName['team'], $teamBName['team']];
}

// Get team names for each match
foreach ($lastMatchesA as $key => $match) {
    list($teamAName, $teamBName) = getMatchTeamNames($db, $match);
    $lastMatchesA[$key]['teamA_name'] = $teamAName;
    $lastMatchesA[$key]['teamB_name'] = $teamBName;
}

foreach ($lastMatchesB as $key => $match) {
    list($teamAName, $teamBName) = getMatchTeamNames($db, $match);
    $lastMatchesB[$key]['teamA_name'] = $teamAName;
    $lastMatchesB[$key]['teamB_name'] = $teamBName;
}
