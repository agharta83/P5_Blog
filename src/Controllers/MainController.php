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
        $slug = $params['slug'] ?? $params;

        // Récup du post
        $post = $this->postManager->findBySlug($slug);
        // Recup des commentaires
        $comments = $this->commentManager->findValidCommentsForPost($post->getId());

        $nbComments = $this->commentManager->countNbCommentsForPost($post->getId());

        // On affiche le template
        echo $this->templates->render('blog/read', [
            'post' => $post,
            'comments' => $comments,
            'nbComments' => $nbComments
        ]);
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

    public function addComment() {

        if (!empty($_POST)) {
            // On récup l'id du post
            $postId = $_POST['post_id'];

            // On va check si l'utilisateur existe 
            // et on le créé en BDD si besoin
            $user = $this->userManager->addUser($_POST);

            // On insére le commentaire en BDD
            $this->commentManager->addComment($_POST, $user);

            // On récup le slug du post
            $postSlug = $this->postManager->findById($postId)->getSlug();

            $this->blogRead($postSlug);

        }
    }

        /**
     * Connexion à l'administration
     *
     * @return Object|Array UserModel|Errors
     */
    public function login()
    {

        $errors = [];

        if (!empty($_POST)) {
            // On identifie l'utilisateur grâce à son login
            $login = $_POST['login'];
            $user = $this->userManager->findByLogin($login);

            if (!$user) {
                $errors[] = "Utilisateur inconnu";
            } else {
                // On teste le mot de passe
                $hash = $user->getPassword();
                //$isValid = password_verify($_POST['password'], $hash); TODO A modifier lorsqu'il y aura la gestion des users
                $isValid = $_POST['password'] == $hash ? true : false;

                if (!$isValid) {
                    $errors[] = "Mot de passe incorrect";
                } else {
                    // On enregistre les infos de l'user en session
                    $this->userManager->saveUserInSession($user);

                    // On redirige l'utilisateur
                    if (count($errors) === 0) $this->redirect('dashboard');
                }
            }

            $headTitle = 'Audrey César | Portfolio Blog';

            echo $this->templates->render('main/home', [
                'title' => $headTitle,
                'errors' => $errors,
                'fields' => $_POST
            ]);
        }
    }

    /**
     * Permet de se déconnecter et donc détruire la session
     *
     * @return void
     */
    public function logout()
    {
        unset($_SESSION['user']);
        $_SESSION = [];

        session_destroy();

        $this->redirect('home');
    }
    
}