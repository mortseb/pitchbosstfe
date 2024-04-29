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

    // Préparer la requête SQL pour récupérer les joueurs déjà sélectionnés
    $stmtSelected = $db->prepare("
        SELECT gk1, def1, def2, def3, def4, mid1, mid2, mid3, atk1, atk2, atk3 
        FROM team 
        WHERE ownerid = :ownerid
    ");

    // Exécuter la requête SQL pour récupérer les joueurs déjà sélectionnés
    $stmtSelected->execute([
        ':ownerid' => $_SESSION['user_id'],    // Remplacer par l'id utilisateur stocké dans la session
    ]);

    // Récupérer les résultats de la requête SQL pour les joueurs déjà sélectionnés
    $selectedPlayers = $stmtSelected->fetch(PDO::FETCH_ASSOC);

    // Créer une chaîne avec les id des joueurs déjà sélectionnés pour la requête SQL suivante
    $selectedPlayersIds = implode(',', array_values($selectedPlayers));

// Préparer la requête SQL pour récupérer les joueurs non sélectionnés
if ($selectedPlayersIds) {
    $stmt = $db->prepare("
        SELECT id, faceLink, eyebrowsLink, eyesLink, mouthLink, noseLink, $noteColumn, totalscore 
        FROM players 
        WHERE ownerid = :ownerid 
        AND id NOT IN ($selectedPlayersIds) 
        ORDER BY $noteColumn DESC
    ");
} else {
    $stmt = $db->prepare("
        SELECT id, faceLink, eyebrowsLink, eyesLink, mouthLink, noseLink, $noteColumn, totalscore 
        FROM players 
        WHERE ownerid = :ownerid 
        ORDER BY $noteColumn DESC
    ");
}

    // Exécuter la requête SQL pour récupérer les joueurs non sélectionnés
    $stmt->execute([
        ':ownerid' => $_SESSION['user_id'],    // Remplacer par l'id utilisateur stocké dans la session
    ]);

    // Récupérer les résultats de la requête SQL pour les joueurs non sélectionnés
    $players = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Parcourir tous les joueurs non sélectionnés et générer le contenu HTML
// Inclure la fonction getRatingColor
require '../model/functions.php';

// Parcourir tous les joueurs non sélectionnés et générer le contenu HTML
foreach ($players as $player) {
    $postRatingColor = getRatingColor($player[$noteColumn]);
    $totalScoreColor = getRatingColor($player['totalscore']);
    echo '<div class="player" data-id="' . $player['id'] . '">';
    echo '<div class="player-image">';
    echo '<img src="' . $player['faceLink'] . '" alt="Face">';
    echo '<img src="' . $player['eyebrowsLink'] . '" alt="Face">';
    echo '<img src="' . $player['eyesLink'] . '" alt="Face">';
    echo '<img src="' . $player['mouthLink'] . '" alt="Face">';
    echo '<img src="' . $player['noseLink'] . '" alt="Face">';
    echo '</div>';
    echo '<div class="player-score" style="background-color:' . $postRatingColor . ';">';
    echo '<p>' . $player[$noteColumn] . '</p>';
    echo '</div>';
    echo '<div class="player-total-score" style="background-color:' . $totalScoreColor . ';">';
    echo '<p>' . $player['totalscore'] . '</p>';
    echo '</div>';
    echo '</div>';
}

?>
