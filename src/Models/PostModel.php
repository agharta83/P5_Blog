<?php

namespace MyBlog\Models;

use MyBlog\Models\UserModel;

class PostModel {

    const FRONT = 'FRONT';
    const BACK = 'BACK';
    const GESTION_DE_PROJET = 'GESTION DE PROJET';
    const AUTRE = 'AUTRE';

    
    private $id;
    private $title;
    private $chapo;
    private $content;
    private $created_on;
    private $last_update;
    private $img;
    private $number_reviews;
    private $published_date;
    private $published;
    private $slug;
    private $category;
    private $user_id;

    // Retourne la liste de tous les posts publiés
    public static function findAllPostsPublished() {
        
        // Construction de la requête
        $sql = '
            SELECT * FROM post 
            WHERE published = 1
        ';

        // Connexion à la db
        $conn = \MyBlog\Database::getDb();

        // Exécution de la requête
        $stmt = $conn->query($sql);

        // Return les résultats
        //var_dump($stmt->fetchAll(\PDO::FETCH_CLASS, self::class));
        return $stmt->fetchAll(\PDO::FETCH_CLASS, self::class);
    }

    // Retourne la liste de tous les posts
    public static function findAllPosts() {
        // Construction de la requête
        $sql = '
            SELECT * FROM post
        ';

        // Connexion à la db
        $conn = \MyBlog\Database::getDb();

        // Exécution de la requête
        $stmt = $conn->query($sql);

        // Return les résultats
        //var_dump($stmt->fetchAll(\PDO::FETCH_CLASS, self::class));
        return $stmt->fetchAll(\PDO::FETCH_CLASS, self::class);
    }

    // Retourne un post à partir de son slug
    public static function findBySlug($slug) {

        // Construction de la requete
        $sql = '
            SELECT * FROM post 
            WHERE published = 1 
            AND slug = :slug
        ';

        // Connexion à la db
        $conn = \MyBlog\Database::getDb();

        // Execution de la requete
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':slug', $slug, \PDO::PARAM_STR);
        $stmt->execute();

        // Return les résultats
        //var_dump($stmt->fetchObject(self::class));
        return $stmt->fetchObject(self::class);

    }

    // Récupére l'auteur du post et le return de façon formatée
    public function getPostAuthor() {

        $id = $this->getUser_id();

        $author = UserModel::getUser($id);

        return $author->getFirstname() . ' ' . $author->getLastname();
        
    }

    // Récupére le nombre de posts publiés
    public static function countNbPublishedPost() {

        // Construction de la requête
        $sql = '
            SELECT COUNT(*) FROM post
            WHERE published = 1
        ';

        // Connexion à la db
        $conn = \MyBlog\Database::getDb();

        // Exécution de la requête
        $stmt = $conn->query($sql);

        // Return les résultats
        return $stmt->fetchColumn();
    }

    // Formate le slug // TODO les ' / " ne se supprime pas !
    private function setFormatedSlug($string) {

        // Supression des accents
        $slug = str_replace('è', 'e', $string);
        $slug = str_replace('é', 'e', $slug);
        // Remplacement des majuscules
        $slug = strtolower($slug);
        // Suppression des caractéres non alphanumérique
        $slug = preg_replace('#[^A-Z0-9\'\ ]#i', '', $slug);
        // Supression des espaces multiples
        $slug = str_replace(' ', '_', $slug);
        $slug = str_replace('  ', '_', $slug);
        $slug = str_replace('   ', '_', $slug);
        var_dump($slug);
        return $slug;

    }

    // Créé un nouveau post ou le met à jour si il existe déjà
    public function save() {

        // On crée la requête SQL
        $sql = "
            REPLACE INTO post (
                id,
                title,
                chapo,
                content,
                number_reviews,
                created_on,
                published,
                published_date,
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
                :published,
                :published_date,
                :slug,
                :category,
                :user_id
            )";

        // On récupére le connexion à la BDD
        $conn = \MyBlog\Database::getDb();

        // On récupére l'ID 
        if (empty($this->id)) {
            $this->id = $conn->lastInsertId();
        }

        // On execute la requete
        $stmt = $conn->prepare( $sql );
        $stmt->bindValue( ':title', $this->title );
        $stmt->bindValue( ':chapo', $this->chapo );
        $stmt->bindValue( ':content', $this->content );
        $stmt->bindValue( ':number_reviews', $this->number_reviews );
        $stmt->bindValue( ':created_on', $this->created_on );
        $stmt->bindValue( ':published', $this->published );
        $stmt->bindValue( ':published_date', $this->published_date );
        $stmt->bindValue( ':slug', $this->slug );
        $stmt->bindValue( ':category', $this->category );
        $stmt->bindValue( ':user_id', $this->user_id );
        $stmt->bindValue( ':id', $this->id);
        $stmt->execute();

        //var_dump($stmt->execute()); die();

        $this->id = $conn->lastInsertId();

    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of chapo
     */ 
    public function getChapo()
    {
        return $this->chapo;
    }

    /**
     * Set the value of chapo
     *
     * @return  self
     */ 
    public function setChapo($chapo)
    {
        $this->chapo = $chapo;

        return $this;
    }

    /**
     * Get the value of content
     */ 
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the value of content
     *
     * @return  self
     */ 
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get the value of created_on
     */ 
    public function getCreated_on()
    {
        return date('d-m-Y', strtotime($this->created_on));
    }

    /**
     * Set the value of created_on
     *
     * @return  self
     */ 
    public function setCreated_on($created_on)
    {
        $this->created_on = $created_on;

        return $this;
    }



    /**
     * Get the value of last_update
     */ 
    public function getLast_update()
    {
        if (isset($this->last_update) && !empty($this->last_update)) {
            return date('d-m-Y', strtotime($this->last_update));
        }

        return null;
        
    }

    /**
     * Set the value of last_update
     *
     * @return  self
     */ 
    public function setLast_update($last_update)
    {
        $this->last_update = $last_update;

        return $this;
    }

    /**
     * Get the value of img
     */ 
    public function getImg()
    {
        return $this->img;
    }

    /**
     * Set the value of img
     *
     * @return  self
     */ 
    public function setImg($img)
    {
        $this->img = $img;

        return $this;
    }

    /**
     * Get the value of number_reviews
     */ 
    public function getNumber_reviews()
    {
        return $this->number_reviews;
    }

    /**
     * Set the value of number_reviews
     *
     * @return  self
     */ 
    public function setNumber_reviews($number_reviews)
    {
        $this->number_reviews = $number_reviews;

        return $this;
    }

    /**
     * Get the value of published_date
     */ 
    public function getPublished_date()
    {
        if (isset($this->published_date) && !empty($this->published_date)) {
            return date('d-m-Y', strtotime($this->published_date));
        }
        
        return null;
    }

    /**
     * Set the value of published_date
     *
     * @return  self
     */ 
    public function setPublished_date($published_date)
    {
        $this->published_date = $published_date;

        return $this;
    }

    /**
     * Get the value of published
     */ 
    public function getPublished()
    {
        if ($this->published) {
            return 'Publié';
        } else {
            return 'Brouillon';
        }
        
    }

    /**
     * Set the value of published
     *
     * @return  self
     */ 
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get the value of slug
     */ 
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set the value of slug
     *
     * @return  self
     */ 
    public function setSlug($slug)
    {
        $this->slug = $this->setFormatedSlug($slug);

        return $this;
    }

    /**
     * Get the value of category
     */ 
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set the value of category
     *
     * @return  self
     */ 
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get the value of user_id
     */ 
    public function getUser_id()
    {
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     *
     * @return  self
     */ 
    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }
}