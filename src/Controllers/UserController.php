<?php

namespace MyBlog\Controllers;
class UserController extends CoreController {

    // Connexion
    public function login() {

        echo "j'ai envoyé le formulaire !";

        die();


        // On affiche le template
        echo $this->templates->render('admin/home', [
            
        ]);
    }
    
}