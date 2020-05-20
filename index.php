<?php
// Autoload
require(__DIR__.'/vendor/autoload.php');

// FrontController

$app = new MyBlog\Application();

// Liste de "require"
// Liste de routes
$app->initRoutes();

// Matching des routes
$app->matching();