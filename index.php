<?php
// FrontController

$app = new Application();

// Liste de "require"
// Liste de routes
$app->initRoutes();

// Matching des routes
$app->matching();