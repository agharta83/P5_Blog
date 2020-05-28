<?php
// Autoload
require(__DIR__.'/vendor/autoload.php');

// FrontController
$app = new MyBlog\Application();

// Initialisation des routes
$app->initRoutes();

// Matching des routes
$app->matching();