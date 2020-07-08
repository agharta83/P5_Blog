<?php

namespace MyBlog\Services;

class Validator
{
    /**
     * Echappement des quotes et définit l'encodage en UTF-8
     *
     * @param [type] $variable
     * @return void
     */
    public function escapeOutput($variable)
    {
        return htmlentities($variable, ENT_QUOTES, 'UTF-8');
    }
}