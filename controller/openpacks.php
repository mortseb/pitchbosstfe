<?php
session_start();

require_once '../vendor/autoload.php';

// Load environment variables from .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Connexion à la base de données
$db_host = $_ENV['DB_HOST'];
$db_name = $_ENV['DB_NAME'];
$db_user = $_ENV['DB_USER'];
$db_pass = $_ENV['DB_PASS'];

try {
    $db = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}


$faker = Faker\Factory::create();

if (isset($_GET['type'])) {
    switch ($_GET['type']) {
        case 'gold':
            $numberOfPlayers = 23;
            break;
        case 'silver':
            $numberOfPlayers = 11;
            break;
        case 'bronze':
            $numberOfPlayers = 5;
            break;
        default:
            // Gérer l'erreur, type inconnu
            exit();
    }

    // Obtenir l'ID du propriétaire en fonction du nom d'utilisateur stocké dans la session
    $username = $_SESSION['username'];
    $stmt = $db->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $ownerId = $stmt->fetchColumn();

    if ($ownerId === false) {
        // Gérer l'erreur, utilisateur non trouvé
        exit();
    }

    // Générer les joueurs et les insérer dans la base de données
    for ($i = 0; $i < $numberOfPlayers; $i++) {
        $firstName = $faker->firstName;
        $lastName = $faker->lastName;
        $nationality = $faker->countryCode;
        $noseLink = "../assets/head/nose/" . rand(1, 4) . ".png";
        $faceLink = "../assets/head/face/" . rand(1, 6) . ".png";
        $eyebrowsLink = "../assets/head/eyebrows/" . rand(1, 3) . ".png";
        $mouthLink = "../assets/head/mouth/" . rand(1, 4) . ".png";
        $eyesLink = "../assets/head/eyes/" . rand(1, 4) . ".png";

        $stats = [
            'acceleration' => rand(1, 20),
            'anticipation' => rand(1, 20),
            'blocage' => rand(1, 20),
            'controle' => rand(1, 20),
            'creativite' => rand(1, 20),
            'dribble' => rand(1, 20),
            'degagement' => rand(1, 20),
            'endurance' => rand(1, 20),
            'finition' => rand(1, 20),
            'interception' => rand(1, 20),
            'marquage' => rand(1, 20),
            'passe' => rand(1, 20),
            'positionnement' => rand(1, 20),
            'prisedeballe' => rand(1, 20),
            'puissancetir' => rand(1, 20),
            'recuperation' => rand(1, 20),
            'reflexes' => rand(1, 20),
            'resistance' => rand(1, 20),
            'sauvetage' => rand(1, 20),
            'visiondujeu' => rand(1, 20),
        ];

        $noteGardien = $stats['degagement'] + $stats['prisedeballe'] + $stats['reflexes'] + $stats['sauvetage'] + $stats['anticipation'];
        $noteDefenseur = $stats['positionnement'] + $stats['blocage'] + $stats['interception'] + $stats['recuperation'] + $stats['resistance'];
        $noteMilieu = $stats['controle'] + $stats['creativite'] + $stats['marquage'] + $stats['passe'] + $stats['visiondujeu'];
        $noteAttaquant = $stats['acceleration'] + $stats['dribble'] + $stats['endurance'] + $stats['finition'] + $stats['puissancetir'];

        $totalscore = round(($noteGardien + $noteDefenseur + $noteMilieu + $noteAttaquant) / 4);

        $evolution = rand(1, 20);

        // Insérer le joueur dans la base de données
        $stmt = $db->prepare("INSERT INTO players 
            (firstName, lastName, nationality, noseLink, faceLink, eyebrowsLink, mouthLink, eyesLink, 
            acceleration, anticipation, blocage, controle, creativite, dribble, degagement, endurance, 
            finition, interception, marquage, passe, positionnement, prisedeballe, puissancetir, 
            recuperation, reflexes, resistance, sauvetage, visiondujeu, noteGardien, noteDefenseur, 
            noteMilieu, noteAttaquant, totalscore, evolution, ownerid, age) 
            VALUES 
            (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 16)");

        $stmt->execute([$firstName, $lastName, $nationality, $noseLink, $faceLink, $eyebrowsLink, $mouthLink, $eyesLink, 
            $stats['acceleration'], $stats['anticipation'], $stats['blocage'], $stats['controle'], $stats['creativite'], 
            $stats['dribble'], $stats['degagement'], $stats['endurance'], $stats['finition'], $stats['interception'], 
            $stats['marquage'], $stats['passe'], $stats['positionnement'], $stats['prisedeballe'], $stats['puissancetir'], 
            $stats['recuperation'], $stats['reflexes'], $stats['resistance'], $stats['sauvetage'], $stats['visiondujeu'], 
            $noteGardien, $noteDefenseur, $noteMilieu, $noteAttaquant, $totalscore, $evolution, $ownerId]);
    }
            // Supprimer un pack du type ouvert appartenant à l'utilisateur
    $stmt = $db->prepare("DELETE FROM packs WHERE type = ? AND ownerid = ? LIMIT 1");
    $stmt->execute([$_GET['type'], $ownerId]);
    
        header('Location: ../view/new_players.php?numberOfPlayers=' . $numberOfPlayers);

} else {
    $message = "Une erreur est survenue";
    // Redirige vers la page de connexion avec le message en paramètre GET
    header('Location: ../view/open_packs.php?message=' . urlencode($message));}
?>
