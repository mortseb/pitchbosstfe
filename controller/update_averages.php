<?php
    // Démarrer la session
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

    // Enable exception mode for error handling in PDO
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check that all required parameters are set
    if(!isset($_POST['avgGK'], $_POST['avgDEF'], $_POST['avgMID'], $_POST['avgATK'], $_POST['avgTotalScore'])) {
        // You could handle the error here, perhaps return a HTTP status code or a message
        die("Missing parameters");
    }

    // Create a prepared statement
    $stmt = $db->prepare('UPDATE team SET avgGK = :avgGK, avgDEF = :avgDEF, avgMID = :avgMID, avgATK = :avgATK, avgTotalScore = :avgTotalScore WHERE ownerid = :id');

    // Bind the parameters to the SQL query
    $stmt->bindParam(':avgGK', $_POST['avgGK'], PDO::PARAM_STR);
    $stmt->bindParam(':avgDEF', $_POST['avgDEF'], PDO::PARAM_STR);
    $stmt->bindParam(':avgMID', $_POST['avgMID'], PDO::PARAM_STR);
    $stmt->bindParam(':avgATK', $_POST['avgATK'], PDO::PARAM_STR);
    $stmt->bindParam(':avgTotalScore', $_POST['avgTotalScore'], PDO::PARAM_STR);
    $stmt->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_INT);

    // Execute the query
    $stmt->execute();
?>
