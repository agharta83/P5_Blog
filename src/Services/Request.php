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
        $this->files = $_FILES;
        $this->session = new Session($_SESSION);
    }

    /**
     * @return void
     */
    public function getRequest()
    {
        return $this->get;
    }

    /**
     * @return void
     */
    public function postRequest()
    {
        return $this->post;
    }

    /**
     * @return void
     */
    public function filesRequest()
    {
        return $this->files;
    }

    /**
     * @return void
     */
    public function sessionRequest()
    {
        return $this->session;
    }


}