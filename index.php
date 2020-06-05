<?php

error_reporting(E_ALL);

// Démarrage sessions pour stocker les infos de l'utilisateur
session_start();

// Autoload
require(__DIR__.'/vendor/autoload.php');

// FrontController
$app = new MyBlog\Application();

// Initialisation des routes
$app->initRoutes();

// Matching des routes
$app->matching();