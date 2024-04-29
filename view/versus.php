<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="play.css">
    <link rel="stylesheet" href="versus.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <title>PitchBoss</title>
    
     <?php
        require('../controller/isConnected.php');
        include('../controller/getUserInfo.php');
        include ('../controller/fetch_match_data.php'); 
        include ('../model/functions.php'); 
        include('../controller/nextMatchController.php');
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
    <div class="user-infos w-[30%] mx-auto flex flex-row  hover:bg-slate-100/70 bg-slate-100 transition duration-150 text-black rounded-xl">
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
    <div id="background-image flex flex-col">
        
<div id="next-match">
    <h2>Prochain match</h2>
    <p><?php echo date('d-m-Y', strtotime($nextMatchDate)); ?></p>
    <h3>18H</h3>


</div>
<div class="classcontainer">
<a class="voirclass" href="last_match_stats.php">Dernier match</a></div>
<div class="flex flex-col md:flex-row mb-4">
    <div class="team w-[60%] mx-auto md:mr-auto md:w-[30%] md:ml-[15%]" id="team-left">
    <h2><?php echo $teamA['team_name']; ?></h2>
    <?php foreach ($teamA['players'] as $player): ?>
    <div class="player-row">
        <!-- Assurez-vous de remplacer "path_to_your_icons" par le véritable chemin vers vos icônes de position -->
        <img class="player-position" src="images/<?php echo substr($player['position'], 0, -1); ?>.png" alt="<?php echo $player['position']; ?>">
        <span class="player_name"><?php echo substr($player['firstName'], 0, 1) . '. ' . $player['lastName']; ?></span>
        <div class="player-rating scale-[55%] text-xl border-none border-l-2 border-r-2" style="background-color: 
<?php 
    switch ($player['position']) {
        case 'gk1':
            echo getRatingColor($player['noteGardien']);
            break;
        case 'def1':
        case 'def2':
        case 'def3':
        case 'def4':
            echo getRatingColor($player['noteDefenseur']);
            break;
        case 'mid1':
        case 'mid2':
        case 'mid3':
            echo getRatingColor($player['noteMilieu']);
            break;
        case 'atk1':
        case 'atk2':
        case 'atk3':
            echo getRatingColor($player['noteAttaquant']);
            break;
    }
?>
;">
    <?php 
        switch ($player['position']) {
            case 'gk1':
                echo $player['noteGardien'];
                break;
            case 'def1':
            case 'def2':
            case 'def3':
            case 'def4':
                echo $player['noteDefenseur'];
                break;
            case 'mid1':
            case 'mid2':
            case 'mid3':
                echo $player['noteMilieu'];
                break;
            case 'atk1':
            case 'atk2':
            case 'atk3':
                echo $player['noteAttaquant'];
                break;
        }
    ?>
</div>

<span class="player-totalscore" style="background-color: <?php echo getRatingColor($player['totalscore']); ?>;">
    <?php echo $player['totalscore']; ?>
</span>
    </div>
    <?php endforeach; ?>
    <div class="totalmoyenne">
    <div class="notecontainer">
    <img class="poste-icon" src="images/gk.png" alt="GK">
    <span class="score-cercle" style="background-color: <?php echo getRatingColor($teamA['avgGK']); ?>;">
        <?php echo round($teamA['avgGK']); ?>
    </span>
    </div>
    <div class="notecontainer">
    <img class="poste-icon" src="images/def.png" alt="DEF">
    <span class="score-cercle" style="background-color: <?php echo getRatingColor($teamA['avgDEF']); ?>;">
        <?php echo round($teamA['avgDEF']); ?>
    </span>
    </div>
    <div class="notecontainer">
    <img class="poste-icon" src="images/mid.png" alt="MID">
    <span class="score-cercle" style="background-color: <?php echo getRatingColor($teamA['avgMID']); ?>;">
        <?php echo round($teamA['avgMID']); ?>
    </span>
    </div>
    <div class="notecontainer">
    <img class="poste-icon" src="images/atk.png" alt="ATK">
    <span class="score-cercle" style="background-color: <?php echo getRatingColor($teamA['avgATK']); ?>;">
        <?php echo round($teamA['avgATK']); ?>
    </span>
    </div>
    <div class="totalcontainer">

    <span class="score-cercle" style="background-color: <?php echo getRatingColor($teamA['avgTotalScore']); ?>;">
        <?php echo round($teamA['avgTotalScore']); ?>
    </span>
    </div>

    </div>
    <div class="last-matches">
    <h2>5 derniers matchs</h2>
    <ul>
        <?php foreach ($lastMatchesA as $match): ?>
            <li><?php echo $match['teamA_name'] . ' ' . $match['scoreA'] . ' : ' . $match['scoreB'] . ' ' . $match['teamB_name']; ?></li>
        <?php endforeach; ?>
    </ul>
</div>

</div>




<div class="team w-[60%] md:w-[30%] mx-auto md:ml-auto md:mr-[15%]" id="team-right">
    <h2><?php echo $teamB['team_name']; ?></h2>
    <?php foreach ($teamB['players'] as $player): ?>
    <div class="player-row">
        <!-- Assurez-vous de remplacer "path_to_your_icons" par le véritable chemin vers vos icônes de position -->
        <img class="player-position" src="images/<?php echo substr($player['position'], 0, -1); ?>.png" alt="<?php echo $player['position']; ?>">
        <span class="player_name"><?php echo substr($player['firstName'], 0, 1) . '. ' . $player['lastName']; ?></span>
        <div  class="player-rating scale-[55%] text-xl border-none border-l-2 border-r-2" style="background-color: 
<?php 
    switch ($player['position']) {
        case 'gk1':
            echo getRatingColor($player['noteGardien']);
            break;
        case 'def1':
        case 'def2':
        case 'def3':
        case 'def4':
            echo getRatingColor($player['noteDefenseur']);
            break;
        case 'mid1':
        case 'mid2':
        case 'mid3':
            echo getRatingColor($player['noteMilieu']);
            break;
        case 'atk1':
        case 'atk2':
        case 'atk3':
            echo getRatingColor($player['noteAttaquant']);
            break;
    }
?>
;">
    <?php 
        switch ($player['position']) {
            case 'gk1':
                echo $player['noteGardien'];
                break;
            case 'def1':
            case 'def2':
            case 'def3':
            case 'def4':
                echo $player['noteDefenseur'];
                break;
            case 'mid1':
            case 'mid2':
            case 'mid3':
                echo $player['noteMilieu'];
                break;
            case 'atk1':
            case 'atk2':
            case 'atk3':
                echo $player['noteAttaquant'];
                break;
        }
    ?>
</div>

<span class="player-totalscore" style="background-color: <?php echo getRatingColor($player['totalscore']); ?>;">
    <?php echo $player['totalscore']; ?>
</span>
    </div>
    <?php endforeach; ?>
    <div class="totalmoyenne">
        <div class="notecontainer">
    <img class="poste-icon" src="images/gk.png" alt="GK">
    <span class="score-cercle" style="background-color: <?php echo getRatingColor($teamB['avgGK']); ?>;">
        <?php echo round($teamB['avgGK']); ?>
    </span>
    </div>
    <div class="notecontainer">

    <img class="poste-icon" src="images/def.png" alt="DEF">
    <span class="score-cercle" style="background-color: <?php echo getRatingColor($teamB['avgDEF']); ?>;">
        <?php echo round($teamB['avgDEF']); ?>
    </span>
    </div>
    <div class="notecontainer">
    <img class="poste-icon" src="images/mid.png" alt="MID">
    <span class="score-cercle" style="background-color: <?php echo getRatingColor($teamB['avgMID']); ?>;">
        <?php echo round($teamB['avgMID']); ?>
    </span>
    </div>
    <div class="notecontainer">
    <img class="poste-icon" src="images/atk.png" alt="ATK">
    <span class="score-cercle" style="background-color: <?php echo getRatingColor($teamB['avgATK']); ?>;">
        <?php echo round($teamB['avgATK']); ?>
    </span>
    </div>
    <div class="totalcontainer">

    <span class="score-cercle" style="background-color: <?php echo getRatingColor($teamB['avgTotalScore']); ?>;">
        <?php echo round($teamB['avgTotalScore']); ?>
    </span>
    </div>
    </div>
    <div class="last-matches">
    <h2>5 derniers matchs</h2>
    <ul>
        <?php foreach ($lastMatchesB as $match): ?>
            <li><?php echo $match['teamA_name'] . ' ' . $match['scoreA'] . ' : ' . $match['scoreB'] . ' ' . $match['teamB_name']; ?></li>
        <?php endforeach; ?>
    </ul>
</div>
</div>
</div>
</div>


<script src="script.js"></script>
</body>
</html>