<?php

session_start();

// Détruire toutes les variables de session
$_SESSION = array();

// Définir le message de déconnexion
$_SESSION['message'] = "Vous êtes bien déconnecté.";

// Détruire la session
session_destroy();

// Rediriger vers la page index.php
header("Location: index.php");
exit;



