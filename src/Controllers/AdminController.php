<?php

namespace MyBlog\Controllers;

use MyBlog\Services\Uploader;

/**
 * Controller pour l'administration
 */
class AdminController extends CoreController
{

    /**
     * Admincontroller Constructor
     *
     * @param \AltoRouter $router
     */
    public function __construct(\AltoRouter $router) 
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
     * - le nb de commentaires validés
     * - le nb de commentaires à valider
     * - le nb d'utilisateur
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
     * Permet d'afficher la liste de tous les posts avec sa pagination
     *
     * @return void
     */
    public function list($params) 
    {

        $headTitle = 'Dashboard / Posts';

        // Récup la liste des posts en db
        //$posts = $this->postManager->findAllPosts();
        $pagination = $this->postManager->findAllPostsPaginated(6, $params['page']);

        $results = $pagination->getCurrentPageResults();

        $posts = [];

        // On parcourt le tableau de résultat et on génére l'objet PostModel
        foreach ($results as $row) {
            $postId = $row['id'];
            $posts[$postId] = $this->postManager->buildObject($row);
        }

        // On affiche le template
        echo $this->templates->render('admin/posts', [
            'title' => $headTitle,
            'posts' => $posts,
            'pagination' => $pagination
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

            if (isset($_POST['submit'])) {
                // On check $_FILES et on upload l'image
                $this->upload($_FILES);

                $this->postManager->addPost($_POST, $_FILES);

                // On redirige
                $this->redirect('admin_blog_list');
            } else if (isset($_POST['preview'])){
                // L'utilisateur veut prévisualiser le post
                if (isset($_FILES['name']) && !empty($_FILES['name'])) {
                    $this->upload($_FILES);
                }

                $post = $this->postManager->preview($_POST, $_FILES);

                // On affiche le template
                echo $this->templates->render('blog/read', ['post' => $post]);
            }
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
     * @param array $params
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
     * @param array $params
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
     * @param array $params
     * @return void
     */
    public function update($params)
    {

        // Id du post à éditer
        $id = $params['id'];

        // On récupére le post
        $post = $this->postManager->find($id);

        if (!empty($_POST)) {
            // On check $_FILES
            $this->upload($_FILES);

            $this->postManager->updatePost($id, $_POST, $_FILES);

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
     * @param array $files
     * @return void
     */
    private function upload($files)
    {
        if (isset($files['name']) && !empty($files['name'])) {
            $this->checkFiles($files);

            // On upload
            $uploader = new Uploader();
            $uploadResult = $uploader->upload($files['files']);
    
    
            if ($uploadResult !== TRUE) {
                echo 'Impossible d\'enregistrer l\'image.';
            }
        } else {
            return null;
        }

        
    }

    /**
     * Permet de vérifier si il y a un fichier à upload
     *
     * @param array $files
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

    /**
     * Récupére la liste des commentaires paginées et redirige vers la liste des commentaires
     *
     * @param array $params
     * @return void
     */
    public function listComments($params)
    {
        $headTitle = 'Dashboard / Comments';

        $pagination = $this->commentManager->findAllCommentsPaginated(5, $params['page']);

        $results = $pagination->getCurrentPageResults();

        $comments = [];
        
        // On parcourt le tableau de résultat et on génére l'objet PostModel
        foreach ($results as $row) {
            $commentId = $row['id'];
            $comments[$commentId] = $this->commentManager->buildObject($row);
        }

        echo $this->templates->render('admin/comments', [
            'title' => $headTitle,
            'comments' => $comments,
            'pagination' => $pagination
        ]);
    }

    /**
     * Supprimer un commentaire et redirige vers la liste des commentaires
     *
     * @param array $params
     * @return void
     */
    public function deleteComment($params)
    {

        // Id du commentaire à supprimer
        $id = $params['id'];

        // On récup et supprime le commentaire
        $this->commentManager->delete($id);

        // On redirige
        $this->redirect('comments_list');

    }

    /**
     * Valide un commentaire et redirige vers la liste des commentaires
     *
     * @param array $params
     * @return void
     */
    public function validComment($params)
    {
        // Id du commentaire à supprimer
        $id = $params['id'];

        // On récup et supprime le commentaire
        $this->commentManager->valid($id);

        // On redirige
        $this->redirect('comments_list');
    }
}
