<?php

namespace MyBlog\Controllers;

use MyBlog\Managers\CommentManager;
use MyBlog\Managers\PostManager;
use MyBlog\Managers\UserManager;
use MyBlog\Services\Request;

/**
 * Controller Mere servant à instancier le Router, les Managers et le templating
 * il permet de définir des instances et variables globales étendues aux classes enfants
 */
abstract class CoreController {
    
    /**
     * CoreController constructor
     *
     * @param \AltoRouter $router
     */
    public function __construct($router) {

        // On enregistre le router dans le controller
        $this->router = $router;

        // Instance de Plates pour gérer les templates
        $this->templates = new \League\Plates\Engine( __DIR__ . '/../Views' );

        // Instance de la classe Request
        $this->request = new Request();
        $this->get = $this->request->getRequest();
        $this->post = $this->request->postRequest();
        $this->session = $this->request->sessionRequest();

        // On instancie les Managers
        $this->postManager = new PostManager();
        $this->commentManager = new CommentManager();
        $this->userManager = new UserManager();

        // On enregistre les informations de l'utilisateur connecté
        $this->currentUser = $this->getUserConnected();

        // Données globales accessibles dans les vues
        $this->templates->addData([
            'basePath' => $_SERVER['BASE_URI'],
            'router' => $this->router,
            'user' => $this->currentUser,
            'userManager' => $this->userManager,
            'postManager' => $this->postManager,
            'commentManager' => $this->commentManager,
            'session' => $this->session
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

    /**
     * Retourne les infos de l'utilisateur connecté / enregistré en session
     *
     * @return UserModel|false
     */
    public function getUserConnected()
    {

        if ($this->session) {
            if (null !== $this->session->get('user')) {
                return $this->userManager->getUser($this->session->get('user')['id']);
            }
        }

        return false;
    }
    
}