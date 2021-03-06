<?php

namespace MyBlog\Controllers;

/**
 * Classe permettant de piloter la partie administration
 */
class AdminController extends CoreController
{

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
