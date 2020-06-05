<?php

namespace MyBlog\Controllers;

use MyBlog\Services\Uploader;

class CoreController {
    
    public function __construct($router) {

        // Test connection DB
        //$connexion = \MyBlog\Database::getDb();

        // On enregistre le router dans le controller
        $this->router = $router;

        // Instance de Plates pour gérer les templates
        $this->templates = new \League\Plates\Engine( __DIR__ . '/../Views' );

        // Données globales
        $this->templates->addData([
            'basePath' => $_SERVER['BASE_URI'],
            'router' => $this->router
        ]);

    }

    // Permet de faire une redirection
    public function redirect ($routeName, $infos = []) {
        header('Location: ' . $this->router->generate($routeName, $infos));
        exit();
    }
}