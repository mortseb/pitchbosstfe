<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <title>PitchBoss</title>
    
     <?php
        require('../controller/isConnected.php');
        include('../controller/getUserInfo.php');
        include('../model/functions.php');

        
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

    <div class="player-cards-container mt-4">
        <?php 
                include('../controller/getGeneratedPlayers.php');
                foreach ($players as $player) : ?>
      <div class="player-card flex flex-col bg-gradient-to-b from-slate-700 to-slate-900">
        <div class="flex h-full rounded-t justify-center items-center border-2">
      <div class="player-ratings bg-slate-400 hover:bg-[<?php echo getRatingColor($player['totalscore']); ?>]  flex flex-col justify-center items-start w-fit scale-[80%] w-[40%] h-[106%] border-2">
        <div class="player-rating flex mb-1 items-center">
            <span class="position w-[1rem]">G</span>
            <div class="rating-circle hover:scale-[105%]" style="background-color: <?php echo getRatingColor($player['noteGardien']); ?>">
                <?php echo $player['noteGardien']; ?>
            </div>
        </div>
        <div class="player-rating flex mb-1 items-center">
            <span class="position w-[1rem]">D</span>
            <div class="rating-circle hover:scale-[105%]" style="background-color: <?php echo getRatingColor($player['noteDefenseur']); ?>">
                <?php echo $player['noteDefenseur']; ?>
            </div>
        </div>
        <div class="player-rating flex mb-1 items-center">
            <span class="position w-[1rem]">M</span>
            <div class="rating-circle hover:scale-[105%]" style="background-color: <?php echo getRatingColor($player['noteMilieu']); ?>">
                <?php echo $player['noteMilieu']; ?>
            </div>
        </div>
        <div class="player-rating flex mb-1 items-center">
            <span class="position w-[1rem]">A</span>
            <div class="rating-circle hover:scale-[105%]" style="background-color: <?php echo getRatingColor($player['noteAttaquant']); ?>">
                <?php echo $player['noteAttaquant']; ?>
            </div>
        </div>
    </div>
    <div class="flex flex-col mr-[0.5rem] w-[80%] border-2 h-[85%] bg-slate-400 hover:bg-[<?php echo getRatingColor($player['totalscore']); ?>]">
    <div class="player-face scale-[70%] -mt-4 border-2 border-white rounded-3xl bg-slate-800 hover:scale-[75%]">
        <img class="face-element" src="<?php echo $player['faceLink']; ?>" alt="Face">
        <img class="face-element" src="<?php echo $player['noseLink']; ?>" alt="Nose">
        <img class="face-element" src="<?php echo $player['eyebrowsLink']; ?>" alt="Eyebrows">
        <img class="face-element" src="<?php echo $player['mouthLink']; ?>" alt="Mouth">
        <img class="face-element" src="<?php echo $player['eyesLink']; ?>" alt="Eyes">
    </div>
    <div class="justify-self-start player-score scale-[80%] -mt-4 hover:scale-[85%]">
        <div class="score-circle" style="background-color: <?php echo getRatingColor($player['totalscore']); ?>">
            <?php echo $player['totalscore']; ?>
        </div>
    </div>
    </div>
                </div>
<div class=" flex justify-end border-2 border-white rounded-b">
    <div class="player-info flex flex-col text-start ml-2">
        <span class="player-name text-small text-white not-italic -mb-1"><?php echo $player['firstName']; ?></span>
        <span class="player-lastname text-xs text-white italic -mb-2"><?php echo $player['lastName']; ?></span>
    </div>
    <div class="player-flag w-full flex items-center ml-auto mr-2">
    <img class="ml-auto hover:scale-[105%] border-2 border-white"src="../assets/flags/<?php echo strtolower($player['nationality']); ?>.png" alt="<?php echo $player['nationality']; ?>">
    </div>
</div>
</div>
        <?php endforeach; ?>
        </div> <!-- Add this line -->

         
        <script src="script.js"></script>
</body>
</html>
