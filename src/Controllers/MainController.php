<?php

namespace MyBlog\Controllers;

use MyBlog\Managers\PostManager; 
use Myblog\Managers\CommentManager;

class MainController extends CoreController {

    private $postManager;
    //private $commentManager; TODO Manager à faire

    /**
     * Constructeur : permet d'initialiser des attributs
     * 
     * @param object $router
     */
    public function __construct($router)
    {
        // Execution du controller parent
        parent::__construct($router);

        $this->postManager = new PostManager();
        //$this->commentManager = new CommentManager(); TODO A implémenter
    }

    /**
     * Retourne la page d'accueil
     *
     * @return view
     */
    public function home() {
        // Render template
        $headTitle = 'Audrey César | Portfolio Blog';
        echo $this->templates->render('main/home', ['title' => $headTitle]);
    }

    /**
     * Retourne la page "About"
     *
     * @return view
     */
    public function about() {
        echo $this->templates->render('main/about', ['title' => 'about']);
    }

    /**
     * Retourne la page "Contact"
     *
     * @return view
     */
    public function contact() {
        echo $this->templates->render('main/contact', ['title' => 'contact']);
    }

    /**
     * Affiche la page "Blog" avec la liste des posts publiés
     *
     * @return view
     */
    public function list() {

        // Récup la liste des posts en db
        $posts = $this->postManager->findAllPostsPublished();

        // On affiche le template
        echo $this->templates->render('blog/list', [
            'title' => 'Blog', 
            'posts' => $posts
        ]);
        
    }

    /**
     * Affiche la page d'un article
     *
     * @param [string] $params
     * @return view
     */
    public function read($params) {
        
        // Slug du post à afficher
        $slug = $params['slug'];

        // Récup du post
        $post = $this->postManager->findBySlug($slug);

        // On affiche le template
        echo $this->templates->render('blog/read', ['post' => $post]);
    }
    
}