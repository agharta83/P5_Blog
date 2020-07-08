<?php

namespace MyBlog\Services;

/**
 * Classe modélisant les paramètres HTTP Request
 */
class Parameter
{
    /**
     * @var mixed
     */
    private $parameter;

    /**
     * Constructor
     *
     * @param mixed $parameter
     */
    public function __construct($parameter)
    {
        $this->parameter = $parameter;
    }

    /** 
     * @param string $name
     * @return void
     */
    public function getParameter($name)
    {
        if (isset($this->parameter[$name])) {

            return $this->parameter[$name];
        }
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function setParameter($name, $value)
    {
        $this->parameter[$name] = $value;
    }
}