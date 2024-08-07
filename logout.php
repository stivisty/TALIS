<?php

session_start(); // On démarre la session

$_SESSION = array(); // Réinitialisation du tableau de session

session_destroy(); // Destruction de la session en cours

    header('Location: login.php'); // Redirection vers la page d'accueil 
	exit();

?> 