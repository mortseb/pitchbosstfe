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
        include('../controller/countpacks.php');


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

 <div class=" bg-slate-100/80 rounded-lg flex items-center justify center mt-12 w-[80%] mx-auto">

<div class="relative w-[50%]  flex flex-col mx-auto items-center justify-center">
     <div class="group bg-gradient-to-b h-[80%] from-slate-100 to-slate-200 rounded-xl relative drop-shadow transition duration-150 ease-in-out w-[30%] my-8 flex flex-col text-center align-center">
    <img class="my-2" src="images/gold.png" alt="Gold Pack">

    <?php if ($gold_pack_count > 0) : ?>
        <a href="../controller/openpacks.php?type=gold" class="hidden group-hover:flex bg-black/80 text-white rounded-xl justify-center items-center transition absolute w-full h-full duration-150 ease-in-out mx-auto mb-4">Ouvrir</a>
    <?php endif; ?>
</div>
<p>Pack Or : <?php echo $gold_pack_count; ?></p>
    </div>
<div class="relative w-[50%]  flex flex-col items-center justify-center">
     <div class="group bg-gradient-to-b h-[80%] from-slate-100 to-slate-200 rounded-xl relative drop-shadow transition duration-150 ease-in-out w-[30%] my-8 flex flex-col text-center align-center">
    <img class="my-2" src="images/silver.png" alt="Silver Pack">
    <?php if ($silver_pack_count > 0) : ?>
        <a href="../controller/openpacks.php?type=silver" class="hidden group-hover:flex bg-black/80 text-white rounded-xl justify-center items-center transition absolute w-full h-full duration-150 ease-in-out mx-auto mb-4">Ouvrir</a>
    <?php endif; ?>
</div>
<p>Pack Argent : <?php echo $silver_pack_count; ?></p>

    </div>
    <div class="relative w-[50%]  flex flex-col items-center justify-center">
     <div class="group bg-gradient-to-b h-[80%] from-slate-100 to-slate-200 rounded-xl relative drop-shadow transition duration-150 ease-in-out w-[30%] my-8 flex flex-col text-center align-center">
    <img class="my-2" src="images/bronze.png" alt="Bronze Pack">
    <?php if ($bronze_pack_count > 0) : ?>
        <a href="../controller/openpacks.php?type=bronze" class="hidden group-hover:flex bg-black/80 text-white rounded-xl justify-center items-center transition absolute w-full h-full duration-150 ease-in-out mx-auto mb-4">Ouvrir</a>
    <?php endif; ?>
</div>
<p>Pack Bronze : <?php echo $bronze_pack_count; ?></p>

    </div>
</div> 
    <script src="script.js"></script>
</body>
</html>