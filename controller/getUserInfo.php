<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Vérifiez si la session de l'utilisateur est active
if (!isset($_SESSION['username'])) {
    header('Location: ../view/connection.php');
    exit;
}

$username = $_SESSION['username'];
require __DIR__ . '/vendor/autoload.php';

// Load environment variables from .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Connexion à la base de données
$db_host = $_ENV['DB_HOST'];
$db_name = $_ENV['DB_NAME'];
$db_user = $_ENV['DB_USER'];
$db_pass = $_ENV['DB_PASS'];

// Crée une nouvelle connexion à la base de données
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Vérifie la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Prépare la requête pour chercher les informations de l'utilisateur
$stmt = $conn->prepare("SELECT id, username, credits, team FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

// Vérifie si un utilisateur a été trouvé
if ($result->num_rows > 0) {
    // Fetch les données de l'utilisateur
    $user = $result->fetch_assoc();

} else {
    echo "Aucun utilisateur trouvé avec le nom d'utilisateur: $username";
}

// Ferme la connexion
$stmt->close();
$conn->close();
?>
