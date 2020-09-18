<?php

namespace MyBlog\Controllers\Admin;

/**
 * Classe permettant de piloter la partie administration
 */
class CoreController extends \MyBlog\Controllers\CoreController
{

    /**
     * Admincontroller Constructor
     *
     * @param \AltoRouter $router
     */
    public function __construct(\AltoRouter $router, $templates)
    {
        // Execution du constructeur parent
        parent::__construct($router, $templates);

        // On verifie que l'utilisateur est connecté et si c'est un admin
        if (!$this->currentUser || $this->currentUser->isAdmin() == false) {
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
     *
     * @return void
     */
    public function dashboard()
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
        return $this->renderView('admin/home', [
            'title' => $headTitle,
            'countDatas' => $countDatas
        ]);
    }

}
