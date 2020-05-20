<?php

namespace MyBlog\Controllers;

class CoreController {
    
    public function __construct() {
        
        // Instance de Plates pour gérer les templates
        $this->templates = new \League\Plates\Engine( __DIR__ . '/../Views' );

        // Données globales
        $this->templates->addData([
            'basePath' => $_SERVER['BASE_URI']
        ]);

    }
}