<?php

namespace MyBlog\Controllers;

use MyBlog\Managers\PostManager;
use MyBlog\Managers\UserManager;
use MyBlog\Services\Uploader;

class AdminController extends CoreController {

    private $postManager;
    private $userManager;

    public function __construct($router) 
    {
        parent::__construct($router);

        $this->postManager = new PostManager();
        $this->userManager = new UserManager();
    }

    /**
     * Connexion à l'administration
     *
     * @return Object|Array UserModel|Errors
     */
    public function login() {

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
                //$isValid = password_verify($_POST['password'], $hash); TODO A changer lorsque l'inscription aura été faite car le MDP n'est pas hash en bdd
                $isValid = $_POST['password'] == $hash ? true : false;

                if (!$isValid) {
                    $errors[] = "Mot de passe incorrect";
                } else {
                    // On identifie l'utilisateur
                    $user = $this->userManager->login($user);

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
    public function logout() {
        unset($_SESSION['user']);
        $_SESSION = [];

        session_destroy();

        $this->redirect('home');
    }

    /**
     * Permet d'accéder à la page d'accueil de l'administration et récupére les infos à afficher :
     * - le nb de post publiés
     *
     * @return void
     */
    public function home() {

        $headTitle = 'Dashboard';

        // On récupére les datas à afficher (posts, projets, commentaires, users)
        // TODO afficher aussi des notifs pour les posts en brouillon, et les commentaires à valider
        $nbPublishedPosts = $this->postManager->countNbPublishedPost();

        // On insére les datas dans un tableau
        $countDatas = [
            'posts' => $nbPublishedPosts
        ];


        // On affiche le template
        echo $this->templates->render('admin/home', [
            'title' => $headTitle,
            'countDatas' => $countDatas
        ]);
    }

    /**
     * Permet d'afficher la liste de tous les posts dans l'administration
     *
     * @return void
     */
    public function list () {

        // Récup la liste des posts en db
        $posts = $this->postManager->findAllPosts();

        $headTitle = 'Dashboard / Posts';

        // On affiche le template
        echo $this->templates->render('admin/posts', [
            'title' => $headTitle, 
            'posts' => $posts
        ]);
    }

    /**
     * Permet de créer un post
     *
     * @return void
     */
    public function createNewPost() {

        // Le formulaire de création du post a été soumis
        if (!empty($_POST)) {
            $post = new PostManager();

            // On check $_FILES et on upload l'image
            $this->upload($_FILES);

            $post->addPost($_POST, $_FILES);

            // On redirige
            $this->redirect('admin_blog_list');
            

        } else {
            // On affiche la page de création d'un nouveau post
            $headTitle = 'Dashboard / Nouveau post';

            echo $this->templates->render('admin/new_post', [
                'title' => $headTitle
            ]);
        }

    }

    public function read($params) {

        // Slug du post à afficher
        $slug = $params['slug'];

        // Récup du post
        $post = PostModel::findBySlug($slug);

        // On affiche le template
        echo $this->templates->render('blog/read', ['post' => $post]);
    }

    public function delete($params) {
        
        // Id du post à supprimer
        $id = $params['id'];

        // On supprime le post
        $post = PostModel::find($id);
        $post->delete();

        // On redirige
        $this->redirect('admin_blog_list');
    }

    public function update($params) {

        // Id du post à éditer
        $id = $params['id'];

        // On récupére le post
        $post = PostModel::find($id);

        if (!empty($_POST)) {
            
            $post->setCategory($_POST['category']);
            $post->setTitle($_POST['titre']);
            $post->setChapo($_POST['chapo']);
            $post->setcontent($_POST['content']);

            // On check $_FILES
            try {
                if (!$_FILES) {
                    throw new \UnexpectedValueException('Un problème est survenu pendant le téléchargement. Veuillez réessayer.');
                }
            } catch (\Exception $e) {
                echo $e->getMessage();
                exit();
            }

            // On upload
            if (!$_FILES || $_FILES['files']['name'][0] !== $post->getImg()) {
                $uploader = new Uploader();
                $uploadResult = $uploader->upload($_FILES['files']);
    
                
                if ($uploadResult !== TRUE) {
                    echo 'Impossible d\'enregistrer l\'image.';
                }

                // On ne modifie l'img que si elle est différente
                $post->setImg($_FILES['files']['name'][0]);
            }
               
            $post->setSlug($_POST['titre']);

            // On incrémente les reviews
            $nbReviews = $post->getNumber_reviews();
            $post->setNumber_reviews($nbReviews + 1);

            $post->setUser_id('1'); // TODO Faire la requete / méthode pour retrouver l'user id quand la partie authentification sera codée

            if (isset($_POST['published']) && !empty($_POST['published'] && $_POST['published'] == 'on')) {
                $post->setPublished_date(date("Y-m-d"));
                $post->setPublished(1);
            } else if (!isset($_POST['published'])) {
                $post->setPublished(0);
            }
            
            $post->setLast_update((date("Y-m-d")));

            // On enregistre
            $post->save();

            // On redirige
            $this->redirect('admin_blog_list');
        } else {
        
            // On redirige
            $headTitle = 'Dashboard / Edition de post';

            echo $this->templates->render('admin/update_post', [
                'title' => $headTitle,
                'post' =>$post
            ]);
        }
         
    }

    /**
     * Permet d'upload l'image
     *
     * @param Globals $files
     * @return void
     */
    private function upload($files)
    {
        $this->checkFiles($files);

        // On upload
        $uploader = new Uploader();
        $uploadResult = $uploader->upload($files['files']);

        
        if ($uploadResult !== TRUE) {
            echo 'Impossible d\'enregistrer l\'image.';
        }

    }

    /**
     * Permet de vérifier si il y a un fichier à upload
     *
     * @return Exception
     */
    private function checkFiles($files)
    {
        // On check $_FILES
        try {
            if (!$files) {
                throw new \UnexpectedValueException('Un problème est survenu pendant le téléchargement. Veuillez réessayer.');
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            exit();
        }
    }

}