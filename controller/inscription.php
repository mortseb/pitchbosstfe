<?php
// Récupère les données du formulaire
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$password2 = $_POST['password2'];
$team = $_POST['team'];

// Hash le mot de passe pour la sécurité
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
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

// Vérifie si le pseudo existe déjà
$check_stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$check_stmt->bind_param("s", $username);
$check_stmt->execute();
$result = $check_stmt->get_result();

if ($result->num_rows > 0) {
    // Si les résultats sont trouvés, alors le pseudo existe déjà
    $message = "Le pseudo existe déjà";
    header('Location: ../view/connection.php?message=' . urlencode($message));
    exit;
}
if ($password !== $password2) {
    // Si les résultats sont trouvés, alors le pseudo existe déjà
    $message = "La confirmation du mot de passe a renvoyé une erreur";
    header('Location: ../view/connection.php?message=' . urlencode($message));
    exit;
}

// Vérifie si le mail existe déjà
$check_stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$check_stmt->bind_param("s", $email);
$check_stmt->execute();
$result = $check_stmt->get_result();

if ($result->num_rows > 0) {
    // Si les résultats sont trouvés, alors le mail existe déjà
    $message = "L'adresse mail est déjà utilisée";
    header('Location: ../view/connection.php?message=' . urlencode($message));
    exit;
}

// Vérifie si l'équipe existe déjà
$check_stmt = $conn->prepare("SELECT * FROM users WHERE team = ?");
$check_stmt->bind_param("s", $team);
$check_stmt->execute();
$result = $check_stmt->get_result();

if ($result->num_rows > 0) {
    // Si les résultats sont trouvés, alors le pseudo existe déjà
    $message = "Ce nom d'équipe est déjà utilisé";
    header('Location: ../view/connection.php?message=' . urlencode($message));
    exit;
}

// Prépare la requête SQL
$stmt = $conn->prepare("INSERT INTO users (username, email, password, team, verified, credits) VALUES (?, ?, ?, ?, 0, 10000)");
$stmt->bind_param("ssss", $username, $email, $hashed_password, $team);

// Exécute la requête
if ($stmt->execute()) {
//     // Génère le code de vérification unique
//     $verificationCode = uniqid();

//     // Enregistre le code de vérification dans la table verification_codes
//     $verificationStmt = $conn->prepare("INSERT INTO verification_codes (username, code) VALUES (?, ?)");
//     $verificationStmt->bind_param("ss", $username, $verificationCode);
//     $verificationStmt->execute();

// // Envoie de l'e-mail de vérification
// $to = $email;
// $subject = "Vérification de votre adresse e-mail";
// $message = "Bonjour $username,\n\nVeuillez cliquer sur le lien suivant pour vérifier votre adresse e-mail :\n\n";
// $message .= "http://mortseb.com/pitchboss/controller/verify.php?code=$verificationCode";
// $headers = "From: sebastienmortiers@gmail.com\r\n"; // Ajoutez le retour à la ligne "\r\n"
// $headers .= "Content-type: text/plain; charset=UTF-8\r\n"; // Définit le charset en UTF-8

// mail($to, $subject, $message, $headers);


    // Enregistre le message dans la session
    $message = "Utilisateur créé.";

    // Insère une nouvelle équipe dans la table "team"
    $ownerid = $conn->insert_id;  // Récupère l'id de l'utilisateur qui vient d'être inséré
    $insertTeamStmt = $conn->prepare("INSERT INTO team (ownerid, nextmatch) VALUES (?, 0)");
    $insertTeamStmt->bind_param("i", $ownerid);
    $insertTeamStmt->execute();

    // Redirige vers la page de connexion avec le message en paramètre GET
    header('Location: ../view/connection.php?message=' . urlencode($message));
    exit;
} else {
    echo "Erreur: " . $stmt->error;
}


// Ferme la connexion
$stmt->close();
$conn->close();
?>
