<?php
session_start();
session_destroy();

// Redirigez l'utilisateur vers la page de connexion ou toute autre page appropriée
header('Location: ../view/connection.php');
exit;
?>
