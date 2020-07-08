<?php

namespace MyBlog;

/**
 * Routing
 */
class Application {

    public function __construct() {
        $this->router = new \AltoRouter();
        $this->router->setBasePath($_SERVER['BASE_URI']);
    }

    // Différentes URL de l'app dans Altorouter
    public function initRoutes() {
        
        /** Public  */
        // MainController
        $this->router->map('GET', '/', ['MainController', 'home'], 'home');
        $this->router->map('GET', '/about', ['MainController', 'about'], 'about');
        $this->router->map('GET', '/contact', ['MainController', 'contact'], 'contact');
        // Blog
        $this->router->map('GET', '/blog/[:page]', ['MainController', 'blogList'], 'blog_list');
        $this->router->map('GET', '/blog/[:page]/[:slug]', ['MainController', 'blogRead'], 'blog_read');
        $this->router->map('POST', '/comment/add', ['MainController', 'addComment'], 'add_comment');
        // Portfolio
        $this->router->map('GET', '/portfolio', ['MainController', 'projectList'], 'portfolio_list');
        $this->router->map('GET', '/portfolio/[i:id]', ['MainController', 'projectRead'], 'portfolio_read');
        // Connexion
        $this->router->map('GET|POST', '/login', ['MainController', 'login'], 'login');
        $this->router->map('GET', '/logout', ['MainController', 'logout'], 'logout');
        $this->router->map('POST', '/resetPassword', ['MainController', 'resetPassword'], 'reset_password');
        // Contact form
        $this->router->map('POST', '/contactForm', ['MainController', 'contactForm'], 'contact_form');

        /** Administration */
        // Dashboard
        $this->router->map('GET', '/dashboard', ['AdminController', 'dashboard'], 'dashboard');
        // Gestion des posts
        $this->router->map('GET', '/dashboard/posts/[:page]', ['AdminController', 'list'], 'admin_blog_list');
        $this->router->map('GET|POST', '/dashboard/posts/new/[:page]', ['PostController', 'createNewPost'], 'new_post');
        $this->router->map('GET', '/dashboard/posts/read/[:slug]', ['PostController', 'read'], 'read_post');
        $this->router->map('GET', '/dashboard/posts/[i:id]/delete/[:page]', ['PostController', 'delete'], 'delete_post');
        $this->router->map('GET|POST', '/dashboard/posts/update/[i:id]', ['PostController', 'update'], 'update_post');
        // Gestion des commentaires
        $this->router->map('GET', '/dashboard/comments/[:page]', ['CommentController', 'listComments'], 'comments_list');
        $this->router->map('GET', '/dashboard/comments/[i:id]/delete/[:page]', ['CommentController', 'deleteComment'], 'delete_comment');
        $this->router->map('GET', '/dashboard/comments/[i:id]/valid/[:page]', ['CommentController', 'validComment'], 'valid_comment');
        // Gestion des utilisateurs
        $this->router->map('GET', '/dashboard/users/[:page]', ['UserController', 'listUsers'], 'users_list');
        $this->router->map('GET', '/dashboard/users/[i:id]/disable/[:page]', ['UserController', 'disableUser'], 'disable_user');
        $this->router->map('GET', '/dashboard/users/[i:id]/enable/[:page]', ['UserController', 'enableUser'], 'enable_user');
        $this->router->map('GET', '/dashboard/users/[i:id]/promote/[:page]', ['UserController', 'promoteUser'], 'promote_user');
        $this->router->map('GET', '/dashboard/users/[i:id]/downgrade/[:page]', ['UserController', 'downgradeUser'], 'downgrade_user');
        $this->router->map('POST', '/dashboard/users/create/[:page]', ['UserController', 'createUser'], 'create_user');
        $this->router->map('POST', '/dashboard/users/update/[:page]', ['UserController', 'updateUser'], 'update_user');

    }

    // Execution du controller et de la méthode correspondante à l'URL demandée
    public function matching() {

        // Altorouter vérifie si l'URL demandée existe
        $match = $this->router->match();

        if (!$match) {
            // Pas de route // TODO Faire une belle page 404
            die('Route inconnue');
        } else {
            // Route OK, on récupére les infos
            // $match['target'][0] => Nom du controller
            // $match['target'][1] => Nom de la méthode 
            $data = $match['target'];
            $controllerName = '\MyBlog\Controllers\\' . $data[0];
            $methodName = $data[1];

            // Instance du controller
            $controller = new $controllerName($this->router);
            // Execution de la methode
            // $match['params'] => $_GET
            $controller->$methodName($match['params']);

        }
    }
}