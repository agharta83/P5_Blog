<?php

namespace MyBlog\Services;

/**
 * Classe permettant de purifier les données entrantes (input)
 */
class Validator
{
    /**
     * Nettoie les données
     *
     * @param mixed $data
     * @return void
     */
    public static function sanitize($data)
    {
        if (isset($data) && !empty($data) && strlen($data) < 255) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        }

        return $data;
    }

    /**
     * Vérifie si la valeur est un email valide
     *
     * @param string $value
     * @return boolean
     */
    public static function is_email($value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) && !empty($value);
    }

    public static function decode($value)
    {
        return htmlspecialchars_decode($value, ENT_QUOTES);
    }
}