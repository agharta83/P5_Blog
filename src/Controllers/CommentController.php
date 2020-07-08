<?php

namespace MyBlog\Controllers;

class CommentController extends CoreController
{
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

        return $this->renderView('admin/comments', [
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

        // Page courante
        $currentPage = $params['page'];

        // On récup et supprime le commentaire
        $this->commentManager->delete($id);

        // On redirige
        return $this->redirect('comments_list', ['page' => $currentPage]);
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

        // Page courange
        $currentPage = $params['page'];

        // On récup et supprime le commentaire
        $this->commentManager->valid($id);

        // On redirige
        return $this->redirect('comments_list', ['page' => $currentPage]);
    }
}