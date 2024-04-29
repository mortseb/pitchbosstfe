<?php
    // Démarrer la session
    session_start();
    require __DIR__ . '/vendor/autoload.php';
    $type = $_POST['type'];

    // Définir la colonne de note en fonction du type de joueur
    $noteColumn = 'note' . ucfirst($type);

    // Load environment variables from .env file
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    
    // Connexion à la base de données
    $db_host = $_ENV['DB_HOST'];
    $db_name = $_ENV['DB_NAME'];
    $db_user = $_ENV['DB_USER'];
    $db_pass = $_ENV['DB_PASS'];
    
    $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);

    // 1. Mon équipe : aller chercher le nom et l'id de mon équipe.
    $userId = $_SESSION['user_id'];
    $stmt = $db->prepare("SELECT team FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $teamName = $stmt->fetchColumn();

    $stmt = $db->prepare("SELECT id FROM team WHERE ownerid = ?");
    $stmt->execute([$userId]);
    $teamId = $stmt->fetchColumn();

    // 2. Le dernier match : aller chercher les stats du dernier match disputé par mon équipe 
    $stmt = $db->prepare("SELECT * FROM calendrier WHERE (teamA = ? OR teamB = ?) AND (dominationA <> 0 OR dominationB <> 0) ORDER BY id DESC LIMIT 1");
    $stmt->execute([$teamId, $teamId]);
    $lastMatch = $stmt->fetch(PDO::FETCH_ASSOC);

    // 3. Aller chercher le nom de l'équipe adverse grace au deuxième id de la table calendrier.
    $opponentId = $lastMatch['teamA'] == $teamId ? $lastMatch['teamB'] : $lastMatch['teamA'];
    $stmt = $db->prepare("SELECT ownerid FROM team WHERE id = ?");
    $stmt->execute([$opponentId]);
    $opponentOwnerId = $stmt->fetchColumn();

    $stmt = $db->prepare("SELECT team FROM users WHERE id = ?");
    $stmt->execute([$opponentOwnerId]);
    $opponentName = $stmt->fetchColumn();

    // 4. Afficher ces données dans la vue actuelle.
    // Ici, vous pouvez inclure le fichier HTML et utiliser les variables PHP pour afficher les données.
?>
