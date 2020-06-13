<?php

namespace MyBlog\Controllers;

use MyBlog\Services\Uploader;

/**
 * Controller pour l'administration
 */
class AdminController extends CoreController
{

    public function __construct($router) 
    {
        // Execution du constructeur parent
        parent::__construct($router);

        // On verifie que l'utilisateur est connecté et si c'est un admin
        if (!$this->currentUser || !$this->currentUser->isAdmin()) {
            // On le redirige
            $this->redirect('home');
        }
    }

    /**
     * Permet d'accéder à la page d'accueil de l'administration et récupére les infos à afficher :
     * - le nb de post publiés
     * TODO le nb de commentaires
     * TODO le nb d'utilisateur
     * TODO le nb post en attente de publication
     * TODO Notif : Comments en attente de validation, post le plus lus, post le plus commenté
     *
     * @return void
     */
    public function home()
    {

        $headTitle = 'Dashboard';

        // On récupére les datas à afficher (posts, commentaires, users)
        $nbPublishedPosts = $this->postManager->countNbPublishedPost();
        $nbCommentsValidate = $this->commentManager->countNbCommentsValidate();
        $nbCommentsToValidate = $this->commentManager->countNbCommentsToValidate();
        $nbUsers = $this->userManager->countNbUsers();
        //$nbDraftPosts = $this->postManager->countNbDraftPosts();
        //$mostReadPost = $this->postManager->mostReadPost();
        //$mostCommentPost = $this->postManager->mostCommentPost();

        // On insére les datas dans un tableau
        $countDatas = [
            'nbPosts' => $nbPublishedPosts,
            'nbCommentsValid' => $nbCommentsValidate,
            'nbCommentsToValidate' => $nbCommentsToValidate,
            'nbUsers' => $nbUsers
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
    public function list()
    {

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
    public function createNewPost()
    {

        // Le formulaire de création du post a été soumis
        if (!empty($_POST)) {

            // On check $_FILES et on upload l'image
            $this->upload($_FILES);

            $this->postManager->addPost($_POST, $_FILES);

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

    /**
     * Permet d'afficher la page d'un post dans la partie administration
     * TODO implémenter un preview
     *
     * @param mixed $params
     * @return void
     */
    public function read($params)
    {

        // Slug du post à afficher
        $slug = $params['slug'];

        // Récup du post
        $post = $this->postManager->findBySlug($slug);

        // On affiche le template
        echo $this->templates->render('blog/read', ['post' => $post]);
    }

    /**
     * Supprime un post à partir de son Id
     *
     * @param mixed $params
     * @return void
     */
    public function delete($params)
    {

        // Id du post à supprimer
        $id = $params['id'];

        // On récup et supprime le post
        $this->postManager->delete($id);

        // On redirige
        $this->redirect('admin_blog_list');
    }

    /**
     * Met à jour un post en BDD
     *
     * @param mixed $params
     * @return void
     */
    public function update($params)
    {

        // Id du post à éditer
        $id = $params['id'];

        // On récupére le post
        $post = $this->postManager->find($id);

        if (!empty($_POST)) {
            // TODO Faire la même chose que pour addPost
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
                'post' => $post
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

    public function listComments()
    {
        $headTitle = 'Dashboard / Comments';

        $comments = $this->commentManager->findAllComments();

        echo $this->templates->render('admin/comments', [
            'title' => $headTitle,
            'comments' => $comments
        ]);
    }
}
