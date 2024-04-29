<?php
session_start();

// Récupérer l'ID de l'utilisateur à partir des données POST
$ownerid = $_SESSION['user_id'];

// Connexion à la base de données
$db = new PDO('mysql:host=mortsed260.mysql.db;dbname=mortsed260', 'mortsed260', 'Ifomortseb1');

// Préparer la requête SQL pour obtenir les informations de l'équipe
$stmt = $db->prepare("
    SELECT * FROM team 
    WHERE ownerid = :ownerid
");

// Exécuter la requête SQL
$stmt->execute([
    ':ownerid' => $ownerid,
]);

// Récupérer le résultat de la requête
$team = $stmt->fetch(PDO::FETCH_ASSOC);

// Encoder le résultat en JSON et l'envoyer comme réponse
echo json_encode($team);
?>
