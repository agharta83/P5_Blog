<?php

use MyBlog\Application;

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Démarrage sessions pour stocker les infos de l'utilisateur
session_start();

// Autoload
require __DIR__.'/vendor/autoload.php';

// FrontController
$app = new Application();

// Initialisation des routes
$app->initRoutes();

// Matching des routes
$app->matching();
