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

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Vérifie la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupération de l'ID de l'utilisateur
$stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();
$usercount = $result->fetch_assoc();
$userId = $usercount['id'];

// Obtenir le nombre de packs de chaque type pour l'utilisateur
$pack_types = ['gold', 'silver', 'bronze'];
foreach ($pack_types as $type) {
    $stmt = $conn->prepare("SELECT COUNT(*) as pack_count FROM packs WHERE ownerid = ? AND type = ?");
    $stmt->bind_param("is", $userId, $type);
    $stmt->execute();
    $result = $stmt->get_result();
    $pack_info = $result->fetch_assoc();
    ${$type . "_pack_count"} = $pack_info['pack_count'];
}

// Ferme la connexion
$stmt->close();
$conn->close();
?>
