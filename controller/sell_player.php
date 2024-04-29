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

// Get player id
$player_id = $_POST['player_id'];

// Check if player is in the team
$stmt = $conn->prepare("SELECT * FROM team WHERE ownerid = ? AND (gk1 = ? OR def1 = ? OR def2 = ? OR def3 = ? OR def4 = ? OR mid1 = ? OR mid2 = ? OR mid3 = ? OR atk1 = ? OR atk2 = ? OR atk3 = ?)");
$stmt->bind_param("iiiiiiiiiiii", $_SESSION['user_id'], $player_id, $player_id, $player_id, $player_id, $player_id, $player_id, $player_id, $player_id, $player_id, $player_id, $player_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
  // Player is in the team
  header("Location: ../view/player_list.php?message=" . urlencode("Vous ne pouvez pas vendre de joueur enregistré dans votre équipe"));
  exit();
}

// Get player nationality
$stmt = $conn->prepare("SELECT nationality FROM players WHERE id = ?");
$stmt->bind_param("i", $player_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 0) {
  // Player not found
  header("Location: ../view/player_list.php?message=" . urlencode("Joueur non trouvé"));
  exit();
}
$player_nationality = $result->fetch_assoc()['nationality'];

// Get next match nationality
$stmt = $conn->prepare("SELECT nextnat FROM next_match LIMIT 1");
$stmt->execute();
$result = $stmt->get_result();
$next_match_nationality = $result->fetch_assoc()['nextnat'];

// Calculate credits
$credits = $next_match_nationality == $player_nationality ? 100 : 50;

// Update user credits
$stmt = $conn->prepare("UPDATE users SET credits = credits + ? WHERE id = ?");
$stmt->bind_param("ii", $credits, $_SESSION['user_id']);
$stmt->execute();

// Delete player
$stmt = $conn->prepare("DELETE FROM players WHERE id = ?");
$stmt->bind_param("i", $player_id);
$stmt->execute();

// Redirect
header("Location: ../view/player_list.php?message=" . urlencode("Joueur vendu avec succès"));
?>
