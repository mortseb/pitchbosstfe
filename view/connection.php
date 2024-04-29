<?php
session_start();
// Vérifie si un message a été défini
// Vérifie si un message a été passé en paramètre GET


?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.10.4/gsap.min.js"></script>

    <title>PitchBoss</title>
</head>

<body>

    <header>
        <div class="logo-container grid">
            <a id="mainlogo" class="grid justify-self-center" href="index.php">
                <img class="max-w-[22rem]" src="images/logo.png" alt="logo">
            </a>
        </div>

    </header>
    <?php if (isset($_GET['message'])) {
        // Affiche le message
        echo '<div class="message">' . htmlspecialchars($_GET['message']) . '</div>';
    } ?>
<div class=" mt-24 body-content flex flex-col items-center md:flex-row md:items-start justify-between ">

<div class="form-container rounded-lg flex-grow-0 mb-8 md:mb-0 pb-0 bg-gradient-to-l from-slate-200 to-slate-100 ">

    <div class="switch-container">
        <span class="roboto font-bold uppercase text-small mr-2">Connexion</span>
        <label class="switch h-[1rem]">
            <input class=" h-[1rem]" type="checkbox" id="form-switch">
            <span class="slider h-[1rem]"></span>
        </label>
        <span class="roboto font-bold uppercase text-small ml-2">Inscription</span>
    </div>

    <form id="login-form" action="../controller/connection.php" method="post">
        <input class="text-xs" type="text" name="username" placeholder="Pseudo">
        <input class="text-xs" type="password" name="password" placeholder="Mot de passe">
        <button class="bg-red-500 text-white w-fit px-4 py-2 rounded-lg mt-2 roboto font-bold uppercase text-xs mx-1 hover:scale-105 duration-300" type="submit">Envoyer</button>
    </form>

    <form id="register-form" action="../controller/inscription.php" method="post" style="display: none;">
        <input class="text-xs" type="text" name="username" placeholder="Pseudo">
        <input class="text-xs" type="email" name="email" placeholder="Email">
        <input class="text-xs" type="password" name="password" placeholder="Mot de passe">
        <input class="text-xs" type="password" name="password2" placeholder="Confirmation du mot de passe">
        <input class="text-xs" type="text" name="team" placeholder="Nom de l'équipe">
        <button class="bg-red-500 text-white w-fit px-4 py-2 rounded-lg mt-2 roboto font-bold uppercase text-xs mx-1 hover:scale-105 duration-300" type="submit">Envoyer</button>
    </form>
</div>

<div class="text-container flex flex-col justify-center items-center md:items-start text-6xl my-auto mx-auto text-white">
        <p class="mb-4">Collect <span class="text-red-500">cards</span></p>
        <p class="mb-4">Win <span class="text-red-500">matches</span></p>
        <p>Be the <span class="text-red-500">best</span></p>
    </div>
</div>


    <script src="switchform.js"></script>

    <script>
document.addEventListener('DOMContentLoaded', function () {
    gsap.to(".text-container p", {
        duration: 1,
        opacity: 1,
        x: 0,
        stagger: 0.2,
        ease: "power2.out"
    });
});

</script>
</body>

</html>