<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require __DIR__ . '/vendor/autoload.php';

// Récupère les données du formulaire
$username = $_POST['username'];
$password = $_POST['password'];

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

// Prépare la requête SQL
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);

// Exécute la requête
$stmt->execute();

// Récupère le résultat
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Vérifie le mot de passe
if ($user && password_verify($password, $user['password'])) {
    // Initialiser la session et stocker l'information de l'utilisateur
    $_SESSION['username'] = $user['username'];
    $_SESSION['user_id'] = $user['id'];  // Ligne ajoutée
    $_SESSION['logged_in'] = true;
    // Redirige vers la page d'accueil
    header('Location: ../view/index.php');
}
else {
    // Stocke le message d'erreur dans la session
    $message = "Nom d'utilisateur ou mot de passe incorrect.";
    // Redirige vers la page de connexion
    header('Location: ../view/connection.php?message=' . urlencode($message));
}

// Ferme la connexion
$stmt->close();
$conn->close();
?>
