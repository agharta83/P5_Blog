<?php

namespace MyBlog\Controllers;

/**
 * Controller pour les pages publiques
 */
class MainController extends CoreController {

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
    public function blogList() {

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
     * @param mixed $params
     * @return view
     */
    public function blogRead($params) {
        
        // Slug du post à afficher
        $slug = $params['slug'];

        // Récup du post
        $post = $this->postManager->findBySlug($slug);

        // On affiche le template
        echo $this->templates->render('blog/read', ['post' => $post]);
    }

    /**
     * Affiche la liste des projets
     *
     * @return void
     */
    public function projectList() {
        echo $this->templates->render('portfolio/list', ['title' => 'Portfolio']);
    }

    /**
     * Affiche la page d'un projet
     *
     * @param mixed $params
     * @return void
     */
    public function projectRead($params) {
        // Id du projet
        $projectId = $params['id'];

        echo $this->templates->render('portfolio/read', ['id' => $projectId]);
    }
    
}