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

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get all players not in the team
$stmt = $conn->prepare("SELECT id, nationality FROM players WHERE ownerid = ? AND id NOT IN (SELECT gk1 FROM team WHERE ownerid = ? UNION SELECT def1 FROM team WHERE ownerid = ? UNION SELECT def2 FROM team WHERE ownerid = ? UNION SELECT def3 FROM team WHERE ownerid = ? UNION SELECT def4 FROM team WHERE ownerid = ? UNION SELECT mid1 FROM team WHERE ownerid = ? UNION SELECT mid2 FROM team WHERE ownerid = ? UNION SELECT mid3 FROM team WHERE ownerid = ? UNION SELECT atk1 FROM team WHERE ownerid = ? UNION SELECT atk2 FROM team WHERE ownerid = ? UNION SELECT atk3 FROM team WHERE ownerid = ?)");
$stmt->bind_param("iiiiiiiiiiii", $_SESSION['user_id'], $_SESSION['user_id'], $_SESSION['user_id'], $_SESSION['user_id'], $_SESSION['user_id'], $_SESSION['user_id'], $_SESSION['user_id'], $_SESSION['user_id'], $_SESSION['user_id'], $_SESSION['user_id'], $_SESSION['user_id'], $_SESSION['user_id']);
$stmt->execute();
$players = $stmt->get_result();

// Get next match nationality
$stmt = $conn->prepare("SELECT nextnat FROM next_match LIMIT 1");
$stmt->execute();
$next_match_nationality = $stmt->get_result()->fetch_assoc()['nextnat'];

$total_credits = 0;
while ($player = $players->fetch_assoc()) {
  // Calculate credits
  $credits = $next_match_nationality == $player['nationality'] ? 100 : 50;
  $total_credits += $credits;

  // Delete player
  $stmt = $conn->prepare("DELETE FROM players WHERE id = ?");
  $stmt->bind_param("i", $player['id']);
  $stmt->execute();
}

// Update user credits
$stmt = $conn->prepare("UPDATE users SET credits = credits + ? WHERE id = ?");
$stmt->bind_param("ii", $total_credits, $_SESSION['user_id']);
$stmt->execute();

// Redirect
header("Location: ../view/player_list.php?message=" . urlencode("Tous les joueurs ont été vendus avec succès"));
?>
