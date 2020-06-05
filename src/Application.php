<?php

namespace MyBlog;

class Application {

    public function __construct() {
        $this->router = new \AltoRouter();
        $this->router->setBasePath($_SERVER['BASE_URI']);
    }

    // Différentes URL de l'app dans Altorouter
    public function initRoutes() {
        
        // MainController
        $this->router->map('GET', '/', ['MainController', 'home'], 'home');
        $this->router->map('GET', '/about', ['MainController', 'about'], 'about');
        $this->router->map('GET', '/contact', ['MainController', 'contact'], 'contact');

        // BlogController
        $this->router->map('GET', '/blog', ['BlogController', 'list'], 'blog_list');
        $this->router->map('GET', '/blog/[:slug]', ['BlogController', 'read'], 'blog_read');

        // PortfolioController
        $this->router->map('GET', '/portfolio', ['PortfolioController', 'list'], 'portfolio_list');
        $this->router->map('GET', '/portfolio/[i:id]', ['PortfolioController', 'read'], 'portfolio_read');

        // Administration
        $this->router->map('GET', '/dashboard', ['AdminController', 'home'], 'dashboard');
        $this->router->map('GET', '/dashboard/posts', ['AdminController', 'list'], 'admin_blog_list');
        $this->router->map('GET|POST', '/dashboard/posts/new', ['AdminController', 'createNewPost'], 'new_post');

        // Connexion
        $this->router->map('GET|POST', '/login', ['UserController', 'login'], 'login');

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
            $controller = new $controllerName($this->router);
            // Execution de la methode
            $controller->$methodName($match['params']);

        }
    }
}