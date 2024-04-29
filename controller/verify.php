<?php
// Récupérez le code de vérification depuis l'URL (paramètre GET)
$verificationCode = $_GET['code'];
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


// Vérifie si le code de vérification existe dans la table verification_codes
$stmt = $conn->prepare("SELECT * FROM verification_codes WHERE code = ?");
$stmt->bind_param("s", $verificationCode);
$stmt->execute();
$result = $stmt->get_result();
// Vérifie si l'utilisateur est déjà vérifié
$userStmt = $conn->prepare("SELECT verified FROM users WHERE username = ?");
$userStmt->bind_param("s", $username);
$userStmt->execute();
$userResult = $userStmt->get_result();

if ($userResult->num_rows === 1) {
    $userRow = $userResult->fetch_assoc();
    $isVerified = $userRow['verified'];

    if ($isVerified) {
        // L'utilisateur est déjà vérifié, affichez un message approprié
        $message = "Votre adresse e-mail a déjà été vérifiée. Vous pouvez vous connecter.";
        header('Location: ../view/connection.php?message=' . urlencode($message));
        exit;
    }
}


if ($result->num_rows === 1) {
    // Le code de vérification est valide, marquez l'utilisateur comme vérifié dans la table users
    $row = $result->fetch_assoc();
    $username = $row['username'];

    // Mettez à jour la colonne verified dans la table users pour cet utilisateur
    $updateStmt = $conn->prepare("UPDATE users SET verified = 1 WHERE username = ?");
    $updateStmt->bind_param("s", $username);
    $updateStmt->execute();

    // Supprimez le code de vérification de la table verification_codes
    $deleteStmt = $conn->prepare("DELETE FROM verification_codes WHERE code = ?");
    $deleteStmt->bind_param("s", $verificationCode);
    $deleteStmt->execute();

    // Redirigez l'utilisateur vers la page de connexion avec un message de succès
    $message = "Votre adresse e-mail a été vérifiée avec succès. Vous pouvez maintenant vous connecter.";
    header('Location: ../view/connection.php?message=' . urlencode($message));
    exit;
} else {
    // Le code de vérification est invalide
    $message = "Le code de vérification est invalide. Veuillez vérifier votre e-mail à nouveau ou contactez l'assistance.";
    header('Location: ../view/connection.php?message=' . urlencode($message));
    exit;
}

// Ferme la connexion

?>