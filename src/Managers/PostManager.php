<?php

namespace MyBlog\Managers;

use MyBlog\Models\PostModel;

/**
 * Permet de manager PostModel 
 * en relation avec le controller
 */
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

        $post->setId($row['id'] ?? null);
        $post->setTitle($row['title']);
        $post->setChapo($row['chapo']);
        $post->setContent($row['content']);
        $post->setCreated_on($row['created_on'] ?? null);
        $post->setLast_update($row['last_update'] ?? null);
        $post->setImg($row['img'] ?? null);
        $post->setNumber_reviews($row['number_reviews'] ?? 0);
        $post->setPublished_date($row['published_date'] ?? null);
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
     * @return array PostModel
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
     * @return PostModel
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

    public function findById($id)
    {
        // Construction de la requete
        $sql = '
                SELECT * FROM post 
                WHERE published = 1 
                AND id = :id
            ';

        // Traitement de la requête
        $parameters = [':id' => $id];
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

    /**
     * Permet d'hydrater l'objet PostModel et l'insere en BDD en appelant la méthode save() 
     *
     * @param array $post
     * @param array $files
     * @return void
     */
    public function addPost($post, $files)
    {
        // On gère les datas qui ne sont pas dans le formulaire mais initialisé à chaque création d'un post
        $post['img'] = $files['files']['name'][0];
        $post['slug'] = $post['title'];
        $post['number_reviews'] = 0;
        $post['user_id'] = 1; // TODO Faire la requete / méthode pour retrouver l'user id quand la partie authentification sera codée

        // Si le post est publié immédiatement aprés sa création, on met à jour sa date de publication et son statut
        if (isset($post['published']) && !empty($post['published'] && $post['published'] == 'on')) {
            $post['published_date'] = date("Y-m-d");
            $post['published'] = 1;
        } else if (!isset($post['published'])) {
            $post['published'] = 0;
        }
        
        // On construit l'objet Post
        $newPost = $this->buildObject($post);

        // On l'insére en BDD
        $this->save($newPost);
        
    }

    /**
     * Ajoute un nouveau post un BDD ou le modifie si il existe déjà
     *
     * @param ModelPost $post
     * @return void
     */
    private function save($post)
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

        // Traitemennt de la requete
        $parameters = [
            ':title' => $post->getTitle(),
            ':chapo' => $post->getChapo(),
            ':content' => $post->getContent(),
            ':number_reviews' => $post->getNumber_reviews(),
            ':created_on' => date('Y-m-d'),
            ':last_update' => $post->getLast_update(),
            ':published' =>$post->getPublished(),
            ':published_date' => $post->getPublished_date(),
            ':img' => $post->getImg(),
            ':slug' => $post->getSlug(),
            ':category' => $post->getCategory(),
            ':user_id' => $post->getUser_id(),
            ':id' => $post->getId()
        ];
        
        $this->createQuery($sql, $parameters);
    }

    /**
     * Retourne un post à partir de son Id
     *
     * @param int $id
     * @return ModelPost
     */
    public function find($id)
    {

        // On construit la requete
        $sql = 'SELECT * FROM post WHERE id = :id';

        // Traitement de la requête
        $parameters = [':id' => $id];
        $result = $this->createQuery($sql, $parameters);

        $post = $result->fetch();

        $result->closeCursor();

        return $this->buildObject($post);
    }

    /**
     * Supprime un post en BDD
     *
     * @return void
     */
    public function delete($id)
    {

        // On construit la requête
        $sql = 'DELETE FROM post WHERE id = :id';

        // Traitement de la requête
        $parameters = [':id' => $id];
        $this->createQuery($sql, $parameters);

    }
}
