<?php

use MyBlog\Application;

error_reporting(E_ALL);

// Autoload
require(__DIR__.'/vendor/autoload.php');

// FrontController
$app = new Application();

// Initialisation des routes
$app->initRoutes();

// Matching des routes
$app->matching();