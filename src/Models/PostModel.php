<?php

namespace MyBlog\Models;

use MyBlog\Managers\UserManager;

class PostModel {

    const FRONT = 'FRONT';
    const BACK = 'BACK';
    const GESTION_DE_PROJET = 'GESTION DE PROJET';
    const AUTRE = 'AUTRE';

    /**
     * $id
     *
     * @var int
     */
    private $id;

    /**
     * $title
     *
     * @var string
     */
    private $title;

    /**
     * $chapo
     *
     * @var string
     */
    private $chapo;

    /**
     * $content
     *
     * @var string
     */
    private $content;

    /**
     * $created_on
     *
     * @var Datetime
     */
    private $created_on;

    /**
     * $last_update
     *
     * @var Datetime
     */
    private $last_update;

    /**
     * $img
     *
     * @var string
     */
    private $img;

    /**
     * $number_reviews
     *
     * @var int
     */
    private $number_reviews;

    /**
     * $published_date
     *
     * @var Datetime
     */
    private $published_date;

    /**
     * $published
     *
     * @var bool
     */
    private $published;

    /**
     * $slug
     *
     * @var string
     */
    private $slug;

    /**
     * $category
     *
     * @var enum
     */
    private $category;

    /**
     * $user_id
     *
     * @var int
     */
    private $user_id;

    /**
     * Formated slug for URL
     *
     * @param string $string
     * @param string $delimiter
     * @return void
     */
    private function slugify($string, $delimiter)
    {

        $oldLocale = setlocale(LC_ALL, '0');
        setlocale(LC_ALL, 'en_US.UTF-8');
        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower($clean);
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
        $clean = trim($clean, $delimiter);
        setlocale(LC_ALL, $oldLocale);

        return $clean;
    }

    /**
     * Published or not ?
     *
     * @return boolean
     */
    public function isPublished() {
        
        return $this->published;
    }

    /**
     * Récupére l'auteur du post et le retourne de façon formattée
     *
     * @return string
     */
    public function getPostAuthor()
    {

        $id = $this->getUser_id();

        $author = new UserManager();

        $author = $author->getUser($id);

        return $author->getFirstname() . ' ' . $author->getLastname();
    }

     /**
     * Retourne la valeur de published pour l'afficher correctement
     */ 
    public function getPublishedName()
    {
        if ($this->published) {
            return 'Publié';
        } else {
            return 'Brouillon';
        }
        
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     * 
     * @return self
     */ 
    public function setId($id)
    {
        $this->id = $id;
        
        return $this;
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
        $this->slug = $this->slugify($slug, '_');

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