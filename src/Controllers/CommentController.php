<?php

namespace MyBlog\Controllers;

class CommentController extends CoreController
{
    /**
     * Ajoute un commentaire ainsi qu'un utilisateur et redirige sur le post commenté
     *
     * @return void
     */
    public function addComment($params)
    {

        $post = $this->post;

        $currentPage = $params['page'];

        if (!empty($post)) {
            // On récup l'id du post
            $postId = $post->getParameter('post_id');

            // On va check si l'utilisateur existe 
            // et on le créé en BDD si besoin
            $user = $this->userManager->addUser($post);

            // On enregistre l'user en session
            $this->saveUserInSession($user);

            // On insére le commentaire en BDD
            $this->commentManager->addComment($post, $user);

            // On récup le slug du post
            $postSlug = $this->postManager->findById($postId)->getSlug();

            $this->redirect('blog_read', ['slug' => $postSlug, 'page' => $currentPage]);
        }
    }
}