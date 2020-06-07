<?php

namespace MyBlog\Managers;

use MyBlog\Models\PostModel;

class PostManager extends Database
{

    /**
     * Convertit chaque champ de la table en propriété de l'objet PostModel
     *
     * @param strint|int|bool $row
     * @return object PostModel
     */
    private function buildObject($row)
    {
        $post = new PostModel();

        $post->setId($row['id']);
        $post->setTitle($row['title']);
        $post->setChapo($row['chapo']);
        $post->setContent($row['content']);
        $post->setCreated_on($row['created_on']);
        $post->setLast_update($row['last_update']);
        $post->setImg($row['img']);
        $post->setNumber_reviews($row['number_reviews']);
        $post->setPublished_date($row['published_date']);
        $post->setPublished($row['published']);
        $post->setSlug($row['slug']);
        $post->setCategory($row['category']);
        $post->setUser_id($row['user_id']);

        return $post;

    }    

    /**
     * Retourne la liste de tous les posts publiés
     *
     * @return array PostModel
     */
    public function findAllPostsPublished()
    {

        // Construction de la requête
        $sql = '
                SELECT * FROM post 
                WHERE published = 1
            ';

        
        // Traitement de la requête
        $result = $this->createQuery($sql);

        $posts = [];

        // On parcourt le tableau de résultat et on génére l'objet PostModel
        foreach($result as $row) {
            $postId = $row['id'];
            $posts [$postId] = $this->buildObject($row);
        }

        $result->closeCursor();

        return $posts;

    }

    /**
     * Retourne la liste de tous les posts
     *
     * @return object PostModel
     */
    public function findAllPosts()
    {
        // Construction de la requête
        $sql = '
                SELECT * FROM post
            ';

        // Traitement de la requête
        $result = $this->createQuery($sql);

        $posts = [];

        // On parcourt le tableau de résultat et on génére l'objet PostModel
        foreach($result as $row) {
            $postId = $row['id'];
            $posts [$postId] = $this->buildObject($row);
        }

        $result->closeCursor();

        return $posts;
    }

    /**
     * Retourne un post à partit de son slug
     *
     * @param string $slug
     * @return object PostModel
     */
    public function findBySlug($slug)
    {

        // Construction de la requete
        $sql = '
                SELECT * FROM post 
                WHERE published = 1 
                AND slug = :slug
            ';

        // Traitement de la requête
        $parameters = [':slug' => $slug];
        $result = $this->createQuery($sql, $parameters);

        $post = $result->fetch();

        $result->closeCursor();

        return $this->buildObject($post);
    }

    /**
     * Retourne le nombre de posts publiés
     *
     * @return int
     */
    public function countNbPublishedPost()
    {

        // Construction de la requête
        $sql = '
                SELECT COUNT(*) FROM post
                WHERE published = 1
            ';

        // Traitement de la requête
        $result = $this->createQuery($sql);

        // Return les résultats
        return $result->fetchColumn();
    }

    // Créé un nouveau post ou le met à jour si il existe déjà
    public function save() // TODO à modifier
    {

        // On crée la requête SQL
        $sql = "
                REPLACE INTO post (
                    id,
                    title,
                    chapo,
                    content,
                    number_reviews,
                    created_on,
                    last_update,
                    published,
                    published_date,
                    img,
                    slug,
                    category,
                    user_id
                )
                VALUES (
                    :id,
                    :title,
                    :chapo,
                    :content,
                    :number_reviews,
                    :created_on,
                    :last_update,
                    :published,
                    :published_date,
                    :img,
                    :slug,
                    :category,
                    :user_id
                )";

        // On récupére le connexion à la BDD
        $conn = \MyBlog\Database::getConnexion();

        // On récupére l'ID 
        if (empty($this->id)) {
            $this->id = $conn->lastInsertId();
        }

        // On execute la requete
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':title', $this->title);
        $stmt->bindValue(':chapo', $this->chapo);
        $stmt->bindValue(':content', $this->content);
        $stmt->bindValue(':number_reviews', $this->number_reviews);
        $stmt->bindValue(':created_on', $this->created_on);
        $stmt->bindValue(':last_update', $this->last_update);
        $stmt->bindValue(':published', $this->published);
        $stmt->bindValue(':published_date', $this->published_date);
        $stmt->bindValue(':img', $this->img);
        $stmt->bindValue(':slug', $this->slug);
        $stmt->bindValue(':category', $this->category);
        $stmt->bindValue(':user_id', $this->user_id);
        $stmt->bindValue(':id', $this->id);
        $stmt->execute();

        //var_dump($stmt->execute()); die();

        $this->id = $conn->lastInsertId();
    }

    // Retourne le post à partir de son ID
    public static function find($id) // TODO à refacto
    {

        // On construit la requete
        $sql = 'SELECT * FROM post WHERE id = :id';

        // Connexion à la BDD
        $conn = \MyBlog\Database::getConnexion();

        // On execute la requete
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();

        // Retourne les résultats
        return $stmt->fetchObject(static::class);
    }

    // Suppression d'un post
    public function delete() // TODO A refacto
    {

        // On construit la requête
        $sql = 'DELETE FROM post WHERE id = :id';

        // Connexion à la BDD
        $conn = \MyBlog\Database::getConnexion();

        // On execute la requête
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $this->id, \PDO::PARAM_INT);
        $stmt->execute();
    }
}
