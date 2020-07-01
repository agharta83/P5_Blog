<?php
namespace Myblog\Models;
class UserModel {

    const ADMIN = 'ADMIN';
    const USER = 'USER';
    
    private $id;
    private $login;
    private $password;
    private $email;
    private $statut_user;
    private $user_role;
    private $created_on;
    private $firstname;
    private $lastname;
    private $avatar;

    /**
     * L'utilisateur est Admin ou pas
     *
     * @return boolean
     */
    public function isAdmin() {
        return $this->getUser_role() == self::ADMIN ? true : false;
    }

    /**
     * Retourne le statut de l'utilisateur Actif / Inactif;
     *
     * @return string
     */
    public function getStatut()
    {
        return $this->getStatut_user() == 1 ? 'ACTIF' : 'INACTIF';
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
     * Get the value of login
     */ 
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set the value of login
     *
     * @return  self
     */ 
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of statut_user
     */ 
    public function getStatut_user()
    {
        return $this->statut_user;
    }

    /**
     * Set the value of statut_user
     *
     * @return  self
     */ 
    public function setStatut_user($statut_user)
    {
        $this->statut_user = $statut_user;

        return $this;
    }

    /**
     * Get the value of user_role
     */ 
    public function getUser_role()
    {
        return $this->user_role;
    }

    /**
     * Set the value of user_role
     *
     * @return  self
     */ 
    public function setUser_role($user_role)
    {
        $this->user_role = $user_role;

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
     * Get the value of firstname
     */ 
    public function getFirstname()
    {
        return ucfirst(strtolower($this->firstname));
    }

    /**
     * Set the value of firstname
     *
     * @return  self
     */ 
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get the value of lastname
     */ 
    public function getLastname()
    {
        return ucfirst(strtolower($this->lastname));
    }

    /**
     * Set the value of lastname
     *
     * @return  self
     */ 
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get the value of avatar
     */ 
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set the value of avatar
     *
     * @return  self
     */ 
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }
}