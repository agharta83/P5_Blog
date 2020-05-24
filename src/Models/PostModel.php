<?php

namespace MyBlog\Models;

use MyBlog\Models\UserModel;

class PostModel {

    CONST FRONT = 'FRONT';
    CONST BACK = 'BACK';
    CONST GESTION_DE_PROJET = 'GESTION DE PROJET';
    
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

    // Retourne la liste de tous les posts
    public static function findAll() {
        
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

    public function getPostAuthor() {

        $id = $this->getUser_id();

        $result = UserModel::getUser($id);

        return $result;
        
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
        return $this->created_on;
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
        return $this->last_update;
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
        return date('d-m-Y', strtotime($this->published_date));
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
        return $this->published;
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
        $this->slug = $slug;

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