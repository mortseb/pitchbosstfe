<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="user-id" content="' . $_SESSION['user_id'] . '">
    <title>PitchBoss</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.25/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.25/datatables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="play.css">
    <script src="https://cdn.tailwindcss.com"></script>

     <?php
       require('../controller/isConnected.php');
       include('../controller/getUserInfo.php');
    ?> 
</head>
<body id="myteambody">

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

    <div id="myModal" class="modal">

<!-- Modal content -->
<div class="modal-content">
  <span class="close">&times;</span>
  <p></p>
</div>


</div>
<div class="pitchcontainer scale-[80%]">
<div class="pitchimg">
<img id="pitchimage" src="images/pitch.png" alt="Terrain">


<div class="playerscontainer">
<div class="atkcontainer">
<a href="#" class="addplayer attaquant  hover:scale-105 transition duration-150 ease-in-out" id="atk1">+</a>
<a href="#" class="addplayer attaquant  hover:scale-105 transition duration-150 ease-in-out" id="atk2">+</a>
<a href="#" class="addplayer attaquant  hover:scale-105 transition duration-150 ease-in-out" id="atk3">+</a>
</div>
<div class="midcontainer">
<a href="#" class="addplayer milieu  hover:scale-105 transition duration-150 ease-in-out" id="mid1">+</a>
<a href="#" class="addplayer milieu  hover:scale-105 transition duration-150 ease-in-out" id="mid2">+</a>
<a href="#" class="addplayer milieu  hover:scale-105 transition duration-150 ease-in-out" id="mid3">+</a>
</div>

<div class="defcontainer">
<a href="#" class="addplayer defenseur  hover:scale-105 transition duration-150 ease-in-out" id="def1">+</a>
<a href="#" class="addplayer defenseur  hover:scale-105 transition duration-150 ease-in-out" id="def2">+</a>
<a href="#" class="addplayer defenseur  hover:scale-105 transition duration-150 ease-in-out" id="def3">+</a>
<a href="#" class="addplayer defenseur  hover:scale-105 transition duration-150 ease-in-out" id="def4">+</a>

</div>



<div class="gkcontainer">
<a href="#" class="addplayer gardien  hover:scale-105 transition duration-150 ease-in-out" id="gk1">+</a>
</div>

</div>

</div>
</div>
<div class="notescontainer">
<div class="avg flex flex-col border-l-2 border-black ">
    <img src="images/gk.png" alt="GK Icon">
    <div id="avgGK" class="circle mt-2 hover:scale-105 transition duration-150 ease-in-out"></div>
</div>
<div class="avg flex flex-col border-l-2 border-black">
    <img src="images/def.png" alt="DEF Icon">
    <div id="avgDEF" class="circle mt-2 hover:scale-105 transition duration-150 ease-in-out"></div>
</div>
<div class="avg flex flex-col border-l-2 border-black">
    <img src="images/mid.png" alt="MID Icon">
    <div id="avgMID" class="circle mt-2 hover:scale-105 transition duration-150 ease-in-out"></div>
</div>
<div class="avg flex flex-col border-l-2 border-black">
    <img src="images/atk.png" alt="ATK Icon">
    <div id="avgATK" class="circle mt-2 hover:scale-105 transition duration-150 ease-in-out"></div>
</div>
<div class="avg flex flex-col border-l-4 border-black rounded-lg">
    <img src="images/total.png" alt="Total Icon">
    <div id="avgTotalScore" class="circle mt-2 hover:scale-105 transition duration-150 ease-in-out"></div>
</div>
</div>
    <script src="script.js"></script>
    <script src="play.js"></script>

</body>
</html>