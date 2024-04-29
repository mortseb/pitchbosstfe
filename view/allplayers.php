<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="play.css">
    <link rel="stylesheet" href="versus.css">
    <link rel="stylesheet" href="last-match.css">
    <script src="https://cdn.tailwindcss.com"></script>


    <title>PitchBoss</title>
    
     <?php
        require('../controller/isConnected.php');
        require('../controller/dbconnect.php');
        include('../controller/getUserInfo.php');


    ?> 
</head>
<body>
<header class="flex flex-row w-full">


        <div class="left-[7px] mt-1 fixed bg-white p-1 rounded-lg w-fit z-[501] cursor-pointer border border-2 border-black  hover:scale-105 transition duration-150" onclick="goBack()"> back</div>

<script>
  // La fonction pour revenir à la page précédente
  function goBack() {
    window.history.back();
  }
</script>
<div class="logo-container mx-auto relative flex flex-col justify-center items-center">
    <a id="mainlogo" class="grid sd:justify-self-start md:justify-self-center w-[30%]" href="index.php">
                <img class=" mx-auto" src="images/logo.png" alt="logo">
            </a>
            <div class="body-content relative text-white hidden md:flex justify-center z-[501] my-auto mx-auto h-full">
    <div class="buypacks w-full mt-auto  h-full mt-auto">
        <div class="user-infos w-[30%] mx-auto flex flex-row hover:bg-slate-100/70 bg-slate-100 transition duration-150 text-black rounded-xl">
            <div class="user-info w-fit flex flex-col justify-center items-center mx-0 px-0">
            <img class="infoimg" src="images/username_icon.png" alt="User Icon">
            <p class="text-xs font-light"><?php echo $username; ?></p>
            </div>
            <div class="user-info w-fit flex flex-col justify-center items-center mx-0 px-0">
            <img class="infoimg" src="images/credits_icon.png" alt="Credits Icon">
            <p class="text-xs"><?php echo $user['credits']. " $"; ?></p>
            </div>

            <div class="user-info w-fit flex flex-col justify-center items-center mx-0 px-0">

            <img class="infoimg" src="images/team_icon.png" alt="Team Icon">
            <p class="text-xs"><?php echo $user['team']; ?></p>
            </div>
            
        </div>

    </div>   


 </div>
        </div>

        <div id="menu-icon" class="hover:scale-105 transition duration-150 mt-1 relative bg-white p-1 rounded-lg w-fit z-[501] cursor-pointer">
            <span> Menu </span>
        </div>

        <div id="menu" class="menu-closed ">
        <a id="menulogo" class="relative mt-12 mb-4 w-[70%] hover:scale-105 transition duration-150" href="index.php">
        <img id="menuimg"  src="images/logo.png" alt="Logo">
    </a>

            <a href="versus.php" class="p-2 transition duration-150 mr-auto w-[95%] text-left italic text-xl my-1 hover:bg-gradient-to-r hover:from-slate-700 hover:to-slate-800 hover:rounded-br-3xl hover:text-white">Prochain Match</a>
            <a href="player_list.php" class="p-2 transition duration-150 mr-auto w-[95%] text-left italic text-xl my-1 hover:bg-gradient-to-r hover:from-slate-700 hover:to-slate-800 hover:rounded-br-3xl hover:text-white">Mes joueurs</a>
            <a href="packs_page.php" class="p-2 transition duration-150 mr-auto w-[95%] text-left italic text-xl my-1 hover:bg-gradient-to-r hover:from-slate-700 hover:to-slate-800 hover:rounded-br-3xl hover:text-white">Packs</a>
            <a href="classement.php" class="p-2 transition duration-150 mr-auto w-[95%] text-left italic text-xl my-1 hover:bg-gradient-to-r hover:from-slate-700 hover:to-slate-800 hover:rounded-br-3xl hover:text-white">Classement</a>
            <a href="allplayers.php" class="p-2 transition duration-150 mr-auto w-[95%] text-left italic text-xl my-1 hover:bg-gradient-to-r hover:from-slate-700 hover:to-slate-800 hover:rounded-br-3xl hover:text-white">Meilleurs joueurs</a>
          
            <a id="decologo" class="mt-auto mb-8 bg-red-500 rounded-xl p-2 text-white  hover:scale-105 transition duration-150" href="../controller/logout.php">
        <span  alt="Déconnexion">Déconnexion</span>
    </a>

        </div>
    </header>
    <div class="body-content relative text-white w-full flex justify-center z-[501] my-auto h-full md:hidden">
    <div class="buypacks hover:bg-slate-100/70 bg-slate-100 transition duration-150 text-black rounded-xl h-full mx-8">
        <div class="user-infos flex flex-row">
            <div class="user-info w-fit flex flex-col justify-center items-center mx-2 px-0">
            <img class="infoimg h-[1rem] w-fit" src="images/username_icon.png" alt="User Icon">
            <p class="text-xs font-light"><?php echo $username; ?></p>
            </div>
            <div class="user-info w-fit flex flex-col justify-center items-center mx-2 px-0">
            <img class="infoimg h-[1rem] w-fit" src="images/credits_icon.png" alt="Credits Icon">
            <p class="text-xs"><?php echo $user['credits']. " $"; ?></p>
            </div>

            <div class="user-info w-fit flex flex-col justify-center items-center mx-2 px-0">

            <img class="infoimg h-[1rem] w-fit" src="images/team_icon.png" alt="Team Icon">
            <p class="text-xs"><?php echo $user['team']; ?></p>
            </div>
            
        </div>

    </div>   


 </div>
        <div id="menu-icon" class="hover:scale-105 transition duration-150 mt-1 relative bg-white p-1 rounded-lg w-fit z-[501] cursor-pointer">
            <span> Menu </span>
        </div>

        <div id="menu" class="menu-closed ">
        <a id="menulogo" class="relative mt-12 mb-4 w-[70%] hover:scale-105 transition duration-150" href="index.php">
        <img id="menuimg"  src="images/logo.png" alt="Logo">
    </a>

            <a href="versus.php" class="p-2 transition duration-150 mr-auto w-[95%] text-left italic text-xl my-1 hover:bg-gradient-to-r hover:from-slate-700 hover:to-slate-800 hover:rounded-br-3xl hover:text-white">Prochain Match</a>
            <a href="player_list.php" class="p-2 transition duration-150 mr-auto w-[95%] text-left italic text-xl my-1 hover:bg-gradient-to-r hover:from-slate-700 hover:to-slate-800 hover:rounded-br-3xl hover:text-white">Mes joueurs</a>
            <a href="packs_page.php" class="p-2 transition duration-150 mr-auto w-[95%] text-left italic text-xl my-1 hover:bg-gradient-to-r hover:from-slate-700 hover:to-slate-800 hover:rounded-br-3xl hover:text-white">Packs</a>
            <a href="classement.php" class="p-2 transition duration-150 mr-auto w-[95%] text-left italic text-xl my-1 hover:bg-gradient-to-r hover:from-slate-700 hover:to-slate-800 hover:rounded-br-3xl hover:text-white">Classement</a>
            <a href="allplayers.php" class="p-2 transition duration-150 mr-auto w-[95%] text-left italic text-xl my-1 hover:bg-gradient-to-r hover:from-slate-700 hover:to-slate-800 hover:rounded-br-3xl hover:text-white">Meilleurs joueurs</a>
          
            <a id="decologo" class="mt-auto mb-8 bg-red-500 rounded-xl p-2 text-white  hover:scale-105 transition duration-150" href="../controller/logout.php">
        <span  alt="Déconnexion">Déconnexion</span>
    </a>

        </div>
    </header>
    <div class="body-content relative text-white w-full flex justify-center z-[501] my-auto h-full md:hidden">
    <div class="buypacks bg-slate-100 text-black rounded-xl h-full mx-8">
        <div class="user-infos flex flex-row">
            <div class="user-info w-fit flex flex-col justify-center items-center mx-2 px-0">
            <img class="infoimg h-[1rem] w-fit" src="images/username_icon.png" alt="User Icon">
            <p class="text-xs font-light"><?php echo $username; ?></p>
            </div>
            <div class="user-info w-fit flex flex-col justify-center items-center mx-2 px-0">
            <img class="infoimg h-[1rem] w-fit" src="images/credits_icon.png" alt="Credits Icon">
            <p class="text-xs"><?php echo $user['credits']. " $"; ?></p>
            </div>

            <div class="user-info w-fit flex flex-col justify-center items-center mx-2 px-0">

            <img class="infoimg h-[1rem] w-fit" src="images/team_icon.png" alt="Team Icon">
            <p class="text-xs"><?php echo $user['team']; ?></p>
            </div>
            
        </div>
        </div>   

    </div>   

    <table id="playersTable" class="display">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Propriétaire</th>
            <th>Score total</th>
            <th>Note gardien</th>
            <th>Note défenseur</th>
            <th>Note milieu</th>
            <th>Note attaquant</th>
        </tr>
    </thead>
    <tbody>
<?php
    require('../model/functions.php');  // Assurez-vous d'inclure votre fichier de fonctions

    // Récupérer les données de la base de données
    $stmt = $db->prepare("
        SELECT players.firstName, players.lastName, users.username, players.totalscore, players.noteGardien, players.noteDefenseur, players.noteMilieu, players.noteAttaquant
        FROM players
        JOIN users ON players.ownerid = users.id
        ORDER BY players.totalscore DESC
    ");
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Afficher les données dans le tableau
    foreach ($results as $row) {
        echo "<tr>";
        
        $playerName = "<i class='firstname'>" . htmlspecialchars($row['firstName'], ENT_QUOTES, 'UTF-8') . "</i> <b class='lastname'>" . htmlspecialchars($row['lastName'], ENT_QUOTES, 'UTF-8') . "</b>";
        // Vérifiez si le nom du joueur est "Lauren Von"
        if ($row['firstName'] == "Lauren" && $row['lastName'] == "Von") {
            $playerName = "<a href='../../onepiece/index.php'>" . $playerName . "</a>"; // Remplacez 'URL_DE_VOTRE_LIEN' par le lien souhaité
        }
        echo "<td>" . $playerName . "</td>";
        
        echo "<td>" . htmlspecialchars($row['username'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "<td style='background-color:" . getRatingColor($row['totalscore']) . "'>" . htmlspecialchars($row['totalscore'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "<td style='background-color:" . getRatingColor($row['noteGardien']) . "'>" . htmlspecialchars($row['noteGardien'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "<td style='background-color:" . getRatingColor($row['noteDefenseur']) . "'>" . htmlspecialchars($row['noteDefenseur'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "<td style='background-color:" . getRatingColor($row['noteMilieu']) . "'>" . htmlspecialchars($row['noteMilieu'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "<td style='background-color:" . getRatingColor($row['noteAttaquant']) . "'>" . htmlspecialchars($row['noteAttaquant'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "</tr>";
    }
    
?>
</tbody>

</table>
<script>
$(document).ready(function() {
    $('#playersTable').DataTable({
        "order": [[ 2, "desc" ]]
    });
});
</script>
<script src="script.js"></script>

</body></html>