<?php

namespace MyBlog;

/**
 * Routing
 */
class Application {

    public function __construct() {
        $this->router = new \AltoRouter();
        $this->router->setBasePath($_SERVER['BASE_URI']);
        $this->templates = new \League\Plates\Engine( __DIR__ . '/Views' );
    }

    // Différentes URL de l'app dans Altorouter
    public function initRoutes() {

        /** Public  */
        // MainController
        $this->router->map('GET', '/', ['MainController', 'home'], 'home');
        $this->router->map('GET', '/about', ['MainController', 'about'], 'about');
        $this->router->map('GET', '/contact', ['MainController', 'contact'], 'contact');
        // Blog
        $this->router->map('GET', '/blog/[:page]', ['PostController', 'list'], 'blog_list');
        $this->router->map('GET', '/blog/[:page]/[:slug]', ['PostController', 'read'], 'blog_read');
        $this->router->map('GET', '/single/[:slug]', ['PostController', 'readSingle'], 'read');
        $this->router->map('POST', '/comment/add/[:page]', ['CommentController', 'addComment'], 'add_comment');
        $this->router->map('POST', '/comment/add', ['CommentController', 'addCommentToSingle'], 'add_comment_single');
        // Connexion
        $this->router->map('GET|POST', '/login', ['UserController', 'login'], 'login');
        $this->router->map('GET', '/logout', ['UserController', 'logout'], 'logout');
        $this->router->map('POST', '/resetPassword', ['UserController', 'resetPassword'], 'reset_password');
        // Contact form
        $this->router->map('POST', '/contactForm', ['MainController', 'contactForm'], 'contact_form');

        /** Administration */
        // Dashboard
        $this->router->map('GET', '/dashboard', ['AdminController', 'dashboard'], 'dashboard');
        // Gestion des posts
        $this->router->map('GET', '/dashboard/posts/[:page]', ['Admin\PostController', 'list'], 'admin_blog_list');
        $this->router->map('GET|POST', '/dashboard/posts/new/[:page]', ['Admin\PostController', 'createNewPost'], 'new_post');
        $this->router->map('GET', '/dashboard/posts/read/[:slug]', ['Admin\PostController', 'read'], 'read_post');
        $this->router->map('GET', '/dashboard/posts/preview/[:slug]', ['Admin\PostController', 'preview'], 'preview_post');
        $this->router->map('GET', '/dashboard/posts/[i:id]/delete/[:page]', ['Admin\PostController', 'delete'], 'delete_post');
        $this->router->map('GET|POST', '/dashboard/posts/update/[i:id]', ['Admin\PostController', 'update'], 'update_post');
        // Gestion des commentaires
        $this->router->map('GET', '/dashboard/comments/[:page]', ['Admin\CommentController', 'list'], 'comments_list');
        $this->router->map('GET', '/dashboard/comments/[i:id]/delete/[:page]', ['Admin\CommentController', 'delete'], 'delete_comment');
        $this->router->map('GET', '/dashboard/comments/[i:id]/valid/[:page]', ['Admin\CommentController', 'valid'], 'valid_comment');
        // Gestion des utilisateurs
        $this->router->map('GET', '/dashboard/users/[:page]', ['Admin\UserController', 'list'], 'users_list');
        $this->router->map('GET', '/dashboard/users/[i:id]/disable/[:page]', ['Admin\UserController', 'disable'], 'disable_user');
        $this->router->map('GET', '/dashboard/users/[i:id]/enable/[:page]', ['Admin\UserController', 'enable'], 'enable_user');
        $this->router->map('GET', '/dashboard/users/[i:id]/promote/[:page]', ['Admin\UserController', 'promote'], 'promote_user');
        $this->router->map('GET', '/dashboard/users/[i:id]/downgrade/[:page]', ['Admin\UserController', 'downgrade'], 'downgrade_user');
        $this->router->map('POST', '/dashboard/users/create/[:page]', ['Admin\UserController', 'create'], 'create_user');
        $this->router->map('POST', '/dashboard/users/update/[:page]', ['Admin\UserController', 'update'], 'update_user');

        // 404 Not Found
        $this->router->map('GET', '/notfound', ['MainController', 'notFound'], 'not_found');

    }

    // Execution du controller et de la méthode correspondante à l'URL demandée
    public function matching() {

        // Altorouter vérifie si l'URL demandée existe
        $match = $this->router->match();

        if (!$match) {
            // Pas de route
            $this->redirect('not_found');
        } else {
            // Route OK, on récupére les infos
            // $match['target'][0] => Nom du controller
            // $match['target'][1] => Nom de la méthode
            $data = $match['target'];
            $controllerName = '\MyBlog\Controllers\\' . $data[0];
            $methodName = $data[1];

            // Instance du controller
            $controller = new $controllerName($this->router, $this->templates);
            // Execution de la methode
            // $match['params'] => $_GET
            $controller->$methodName($match['params']);

        }
    }

    public function redirect ($routeName, $infos = []) {
        header('Location: ' . $this->router->generate($routeName, $infos));
        exit();
    }

}
