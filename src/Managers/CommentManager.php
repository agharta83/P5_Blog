<?php

namespace MyBlog\Managers;

use MyBlog\Models\CommentModel;

class CommentManager extends Database
{
    /**
     * Convertit chaque champ de la table en propriété de l'objet CommentModel
     *
     * @param strint|int|bool $row
     * @return object CommentModel
     */
    private function buildObject($row)
    {
        $comment = new CommentModel();

        $comment->setId($row['id'] ?? null);
        $comment->setCreated_on($row['created_on']);
        $comment->setIs_valid($row['is_valid']);
        $comment->setContent($row['content']);
        $comment->setRespond_to($row['respond_to'] ?? null);
        $comment->setPost_id($row['post_id']);
        $comment->setUser_id($row['user_id']);

        return $comment;

    }

    public function findValidCommentsForPost($postId)
    {
        // Construction de la requête
        $sql = '
                SELECT * FROM comment 
                WHERE is_valid = 1
                AND post_id = :postId
                AND respond_to IS NULL
            ';

        // Traitement de la requête
        $parameters = [':postId' => $postId];
        $result = $this->createQuery($sql, $parameters);

        $comments = [];

        // On parcourt le tableau de résultat et on génére l'objet PostModel
        foreach($result as $row) {
            $commentId = $row['id'];
            $comments [$commentId] = $this->buildObject($row);
        }

        $result->closeCursor();

        return $comments;
    }

    public function countNbCommentsForPost($postId)
    {
        // Construction de la requête
        $sql = '
            SELECT COUNT(*) FROM comment 
            WHERE is_valid = 1
            AND post_id = :postId
        ';

        // Traitement de la requête
        $parameters = [':postId' => $postId];
        $result = $this->createQuery($sql, $parameters);

        // Return les résultats
        return $result->fetchColumn();
    }

    public function findCommentWhereHasRespond($commentId)
    {
        // Construction de la requête
        $sql = '
                SELECT * FROM comment 
                WHERE is_valid = 1
                AND respond_to = :commentId
            ';

        // Traitement de la requête
        $parameters = [':commentId' => $commentId];
        $result = $this->createQuery($sql, $parameters);

        $comment = $result->fetch();

        if ($comment) {
            $result->closeCursor();

            return $this->buildObject($comment);
        }

        return false;

        
    }

    // Le commentaire à une réponse
    public function thisCommentHasAnswer($commentId)
    {
        if ($respondTo = $this->findCommentWhereHasRespond($commentId)) {
            return $respondTo;
        }

        return false;
    }
}