<?php

namespace MyBlog\Managers;

use MyBlog\Models\CommentModel;
use MyBlog\Services\PaginatedQuery;
use Pagerfanta\Pagerfanta;
use MyBlog\Services\Parameter;

class CommentManager extends CoreManager
{
    /**
     * Convertit chaque champ de la table en propriété de l'objet CommentModel
     *
     * @param strint|int|bool $row
     * @return object CommentModel
     */
    public function buildObject($row)
    {
        $comment = new CommentModel();

        if (is_array($row)) {
            $comment->setId($row['id'] ?? null);
            $comment->setCreated_on($row['created_on']);
            $comment->setIs_valid($row['is_valid']);
            $comment->setContent($row['content']);
            $comment->setRespond_to($row['respond_to'] ?? null);
            $comment->setPost_id($row['post_id']);
            $comment->setUser_id($row['user_id']);
        }

        if ($row instanceof Parameter) {
            $comment->setId($row->getParameter('id') ?? null);
            $comment->setCreated_on($row->getParameter('created_on'));
            $comment->setIs_valid($row->getParameter('is_valid'));
            $comment->setContent($row->getParameter('content'));
            $comment->setRespond_to($row->getParameter('respond_to') ?? null);
            $comment->setPost_id($row->getParameter('post_id'));
            $comment->setUser_id($row->getParameter('user_id'));
        }

        return $comment;

    }

    /**
     * Retourne les commentaires validés par post
     *
     * @param integer $postId
     * @return CommentModel[]
     */
    public function findValidCommentsForPost(int $postId)
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

        if ($result !== null) {
            $comments = [];

            // On parcourt le tableau de résultat et on génére l'objet PostModel
            foreach ($result as $row) {
                $commentId = $row['id'];
                $comments[$commentId] = $this->buildObject($row);
            }

            return $comments;
        }

        $result->closeCursor();

        return false;
    }

    /**
     * Retourne le nombre de commentaires par post
     *
     * @param integer $postId
     * @return integer
     */
    public function countNbCommentsForPost(int $postId)
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

    /**
     * Récupére un commentaire associé à un autre commentaire
     *
     * @param integer $commentId
     * @return false|CommentModel
     */
    public function findCommentWhoHasAnswer(int $commentId)
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

    /**
     * Retourne un commentaire associé à un autre commentaire
     *
     * @param integer $commentId
     * @return bool|CommentModel
     */
    public function thisCommentHasAnswer(int $commentId)
    {
        if ($respondTo = $this->findCommentWhoHasAnswer($commentId)) {
            return $respondTo;
        }

        return false;
    }

    /**
     * Ajoute un commentaire en BDD
     *
     * @param Parameter $post
     * @param UserModel $user
     * @return void
     */
    public function addComment(Parameter $post, $user)
    {
        // Initialisation
        $post->setParameter('created_on', date('Y-m-d H:i:s'));
        $post->setParameter('is_valid', 0);
        $post->setParameter('user_id', $user->getId());

        $comment = $this->buildObject($post);

        $sql = '
            INSERT INTO comment (
                id,
                created_on,
                is_valid,
                content,
                respond_to,
                post_id,
                user_id
            ) VALUES (
                :id,
                :created_on,
                :is_valid,
                :content,
                :respond_to,
                :post_id,
                :user_id
            )
        ';

        $parameters = [
            ':id' => $comment->getId(),
            ':created_on' => $comment->getCreated_on(),
            ':is_valid' => $comment->getIs_valid(),
            ':content' => $comment->getContent(),
            ':respond_to' => $comment->getRespond_to(),
            ':post_id' => $comment->getPost_id(),
            ':user_id' => $comment->getUser_id()
        ];

        $this->createQuery($sql, $parameters);
    }

    /**
     * Retourne le nombre de commentaires validés
     *
     * @return integer
     */
    public function countNbCommentsValidate()
    {
        // Construction de la requête
        $sql = '
               SELECT COUNT(*) FROM comment
               WHERE is_valid = 1
           ';

        // Traitement de la requête
        $result = $this->createQuery($sql);

        // Return les résultats
        return $result->fetchColumn();
    }

    /**
     * Retourne le nombre de commentaires à valider
     *
     * @return integer
     */
    public function countNbCommentsToValidate()
    {
        // Construction de la requête
        $sql = '
               SELECT COUNT(*) FROM comment
               WHERE is_valid = 0
           ';

        // Traitement de la requête
        $result = $this->createQuery($sql);

        // Return les résultats
        return $result->fetchColumn();
    }

    /**
     * Retourne la liste des commentaires paginés
     *
     * @param integer $perPage
     * @param integer $currentPage
     * @return Pagerfanta
     */
    public function findAllCommentsPaginated(int $perPage, int $currentPage)
    {
        $query = new PaginatedQuery(
            $this->checkConnexion(),
            'SELECT * FROM comment ORDER BY created_on DESC',
            'SELECT COUNT(id) FROM comment'
        );

        return (new Pagerfanta($query))->setMaxPerPage($perPage)->setCurrentPage($currentPage);
    }

    /**
     * Récupére l'auteur du commentaire et le retourne de façon formattée
     *
     * @return string
     */
    public function getCommentAuthor()
    {

        $id = $this->userManager->getUser_id();

        $author = new UserManager();

        $author = $author->getUser($id);

        return $author->getFirstname() . ' ' . $author->getLastname();
    }

    /**
     * Supprime un commentaire
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id)
    {

        // On construit la requête
        $sql = 'DELETE FROM comment WHERE id = :id';

        // Traitement de la requête
        $parameters = [':id' => $id];
        $this->createQuery($sql, $parameters);

    }

    /**
     * Valide un commentaire
     *
     * @param integer $id
     * @return void
     */
    public function valid(int $id)
    {
        // On construit la requête
        $sql = 'UPDATE comment SET is_valid = 1 WHERE id = :id';

        // Traitement de la requête
        $parameters = [':id' => $id];
        $this->createQuery($sql, $parameters);
    }
}
