<?php

session_start(); // On d�marre la session

$_SESSION = array(); // R�initialisation du tableau de session

session_destroy(); // Destruction de la session en cours

    header('Location: login.php'); // Redirection vers la page d'accueil 
	exit();

?> 