<?php

namespace MyBlog;

class Application {

    public function __construct() {
        $this->router = new \AltoRouter();
        $this->router->setBasePath($_SERVER['BASE_URI']);
    }

    // Dump
    public function dump($data) {
        dump($data);
    }

    // Différentes URL de l'app dans Altorouter
    public function initRoutes() {
        
        // $router->map(...);
        $this->router->map('GET', '/', ['MainController', 'home'], 'home');
    }

    // Execution du controller et de la méthode correspondante à l'URL demandée
    public function matching() {

        // Altorouter vérifie si l'URL demandée existe
        $match = $this->router->match();

        if (!$match) {
            // Pas de route
            die('Route inconnue');
        } else {
            // Route OK, on récupére les infos
            $data = $match['target'];
            $controllerName = '\MyBlog\Controllers\\' . $data[0];
            $methodName = $data[1];

            // Instance du controller
            $controller = new $controllerName();
            // Execution de la methode
            $controller->$methodName();

        }
    }
}