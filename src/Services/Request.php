<?php

namespace MyBlog\Services;

/**
 * Classe modélisant HTTP Request
 * permettant l'accés au variables globales
 */
class Request
{

    private $get;
    private $post;
    private $session;
    private $files;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->get = new Parameter($_GET);
        $this->post = new Parameter($_POST);
        $this->files = new Parameter($_FILES);
        $this->session = new Session($_SESSION);
    }

    /**
     * @return Parameter
     */
    public function getRequest()
    {
        return $this->get;
    }

    /**
     * @return Parameter
     */
    public function postRequest()
    {
        return $this->post;
    }

    /**
     * @return Parameter
     */
    public function filesRequest()
    {
        return $this->files;
    }

    /**
     * @return Session
     */
    public function sessionRequest()
    {
        return $this->session;
    }


}