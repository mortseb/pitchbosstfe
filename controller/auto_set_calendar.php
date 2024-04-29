<?php

// Connexion à la base de données
$db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);

// Récupération des équipes de la base de données
$result = $db->query("SELECT id FROM team");
$teams = $result->fetchAll(PDO::FETCH_COLUMN, 0);

// Vérifiez s'il y a un nombre impair d'équipes. Si c'est le cas, ajoutez une équipe fictive (l'équipe bot avec l'id 4).
if (count($teams) % 2 != 0) {
    array_push($teams, 4);
}

$away = array_splice($teams, (count($teams)/2));
$home = $teams;
for ($i = 0; $i < count($home)+count($away)-1; $i++) {
    for ($j = 0; $j < count($home); $j++) {
        $round[$i][$j]["Home"] = $home[$j];
        $round[$i][$j]["Away"] = $away[$j];
    }
    if (count($home)+count($away)-1 > 2) {
        array_unshift($home, array_shift(array_splice($away,1,1)));
        array_push($away, array_pop($home));
    }

    // A la fin de chaque journée, insérez tous les matchs de cette journée dans la base de données
    foreach ($round[$i] as $match) {
        if (!in_array(4, $match)) { // Ne pas insérer les matchs de l'équipe bot
            $db->query("INSERT INTO calendrier (teamA, teamB) VALUES ({$match['Home']}, {$match['Away']})");
        }
    }
}

// Pour les matchs retour, parcourez le tableau $round une deuxième fois et insérez les matchs dans la base de données, mais avec les équipes à domicile et à l'extérieur inversées
foreach ($round as $day) {
    foreach ($day as $match) {
        if (!in_array(4, $match)) { // Ne pas insérer les matchs de l'équipe bot
            $db->query("INSERT INTO calendrier (teamA, teamB) VALUES ({$match['Away']}, {$match['Home']})");
        }
    }
}
?>
