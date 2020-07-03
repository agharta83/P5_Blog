<?php

namespace MyBlog\Services;

/**
 * Classe utilitaire permettant de gérer la session
 */
class Session
{
    private $session;

    /**
     * Constructor
     *
     * @param array $session
     */
    public function __construct($session)
    {
        $this->session = $session;

    }

    /**
     * Démarre une session
     *
     * @return void
     */
    public function init()
    {
        session_start();

    }

    /**
     * Stocke une donnée en session
     *
     * @param string $name
     * @param string|int $value
     * @return void
     */
    public function set($name, $value)
    {
         return $_SESSION[$name] = $value;
    }

    /**
     * Récupére une donnée stockée en session
     *
     * @param string|int $name
     * @return void
     */
    public function get($name)
    {
        if ( $this->check($name)) {
            if (!empty($_SESSION[$name])) {
                return $_SESSION[$name];
            }
        }

        return null;
        
    }

    /**
     * Vérifie qu'une donnée est présent en session
     *
     * @param string|int $name
     * @return bool
     */
    public function check($name)
    {
        return isset($_SESSION[$name]) && array_key_exists($name, $_SESSION);
    }

    /**
     * Supprime une donnée en session
     *
     * @param string|int $name
     * @return bool
     */
    public function remove($name)
    {
        if ($this->check($name)) {
            unset($_SESSION[$name]);

            return !$this->check($name);
        } else {
            return false;
        }
        
    }
    /**
     * Destruction de la session
     */
    public function stop()
    {
        session_destroy();
    }

}