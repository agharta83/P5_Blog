<?php

namespace MyBlog\Controllers;

use MyBlog\Models\UserModel;

class CoreController {
    
    public function __construct($router) {

        // On enregistre le router dans le controller
        $this->router = $router;

        // Instance de Plates pour gérer les templates
        $this->templates = new \League\Plates\Engine( __DIR__ . '/../Views' );

        // Données globales
        $this->templates->addData([
            'basePath' => $_SERVER['BASE_URI'],
            'router' => $this->router,
            'user' => UserModel::getUserConnected()
        ]);

    }

    // Permet de faire une redirection
    public function redirect ($routeName, $infos = []) {
        header('Location: ' . $this->router->generate($routeName, $infos));
        exit();
    }
}