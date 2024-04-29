<?php
require __DIR__ . '/vendor/autoload.php';

// Vérifiez si la session de l'utilisateur est active
if (!isset($_SESSION['username'])) {
    header('Location: ../view/connection.php');
    exit;
}

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


// Récupération de l'ID de l'utilisateur
$stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();
$userpack = $result->fetch_assoc();
$userId = $userpack['id'];

// Prépare la requête pour chercher le nombre de packs de l'utilisateur
$stmt = $conn->prepare("SELECT COUNT(*) as pack_count FROM packs WHERE ownerid = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

// Vérifie si un utilisateur a été trouvé
if ($result->num_rows > 0) {
    // Fetch les données du nombre de packs
    $pack_info = $result->fetch_assoc();

} else {
    echo "Aucun pack trouvé pour l'utilisateur: $userId";
}

// Ferme la connexion
$stmt->close();
$conn->close();
?>
