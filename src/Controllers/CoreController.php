<?php

namespace MyBlog\Controllers;

use MyBlog\Managers\CommentManager;
use MyBlog\Managers\PostManager;
use MyBlog\Managers\UserManager;
use MyBlog\Models\UserModel;

/**
 * Controller Mere servant à instancier le Router, les Managers et le templating
 * il permet de définir des instances et variables globales étendues aux classes enfants
 */
abstract class CoreController {
    
    /**
     * Constructeur
     *
     * @param Object $router
     */
    public function __construct($router) {

        // On enregistre le router dans le controller
        $this->router = $router;

        // Instance de Plates pour gérer les templates
        $this->templates = new \League\Plates\Engine( __DIR__ . '/../Views' );

        // On instancie les Managers
        $this->postManager = new PostManager();
        $this->commentManager = new CommentManager();
        $this->userManager = new UserManager();

        // On enregistre les informations de l'utilisateur connecté
        $this->currentUser = $this->userManager->getUserConnected();

        // Données globales
        $this->templates->addData([
            'basePath' => $_SERVER['BASE_URI'],
            'router' => $this->router,
            'user' => $this->currentUser,
            'userManager' => $this->userManager,
            'postManager' => $this->postManager,
            'commentManager' => $this->commentManager
        ]);

    }

    /**
     * Permet de faire une redirection
     *
     * @param string $routeName
     * @param array $infos
     * @return void
     */
    public function redirect ($routeName, $infos = []) {
        header('Location: ' . $this->router->generate($routeName, $infos));
        exit();
    }
}