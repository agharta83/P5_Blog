<?php

namespace Myblog\Models;

use MyBlog\Managers\CommentManager;
use MyBlog\Managers\UserManager;

class CommentModel {
    
    private $id;
    private $created_on;
    private $is_valid;
    private $content;
    private $respond_to;
    private $post_id;
    private $user_id;

    public function getCommentAuthor()
    {
        $id = $this->getUser_id();

        $author = new UserManager();

        $author = $author->getUser($id);

        return $author->getFirstname() . ' ' . $author->getLastname();
    }

    public function getFormatedDate()
    {
        setlocale(LC_TIME, ['fr', 'fra', 'fr_FR']);
        $date = strftime('%A %d %B %G %H:%M', strtotime($this->created_on));
        
        return $date;
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
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * Get the value of is_valid
     */ 
    public function getIs_valid()
    {
        return $this->is_valid;
    }

    /**
     * Set the value of is_valid
     *
     * @return  self
     */ 
    public function setIs_valid($is_valid)
    {
        $this->is_valid = $is_valid;

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
     * Get the value of respond_to
     */ 
    public function getRespond_to()
    {
        return $this->respond_to;
    }

    /**
     * Set the value of respond_to
     *
     * @return  self
     */ 
    public function setRespond_to($respond_to)
    {
        $this->respond_to = $respond_to;

        return $this;
    }

    /**
     * Get the value of post_id
     */ 
    public function getPost_id()
    {
        return $this->post_id;
    }

    /**
     * Set the value of post_id
     *
     * @return  self
     */ 
    public function setPost_id($post_id)
    {
        $this->post_id = $post_id;

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