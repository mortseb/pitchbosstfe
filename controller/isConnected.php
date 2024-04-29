<?php
session_start();

if (!isset($_SESSION['logged_in'])) {
    // l'utilisateur n'est pas connecté, le rediriger vers la page de connexion/inscription
    header('Location: ../view/connection.php');
    exit();
}
?>