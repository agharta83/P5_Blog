<?php

namespace MyBlog\Controllers;

use MyBlog\Models\UserModel;
class UserController extends CoreController {

    // Connexion
    public function login() {


        $errors = [];

        if (!empty($_POST)) {
            // On identifie l'utilisateur grâce à son login
            $login = $_POST['login'];
            $user = UserModel::findByLogin($login);

            if (!$user) {
                $errors[] = "Utilisateur inconnu";
            } else {
                // On teste le mot de passe
                $hash = $user->getPassword();
                //$isValid = password_verify($_POST['password'], $hash); TODO A changer lorsque l'inscription aura été faite car le MDP n'est pas hash en bdd
                $isValid = $_POST['password'] == $hash ? true : false;

                if (!$isValid) {
                    $errors[] = "Mot de passe incorrect";
                } else {
                    // On identifie l'utilisateur
                    UserModel::login($user);

                    // On redirige l'utilisateur
                    if (count($errors) === 0) $this->redirect('dashboard');
                }
            }

            $headTitle = 'Audrey César | Portfolio Blog';

            echo $this->templates->render('main/home', [
                'title' => $headTitle,
                'errors' => $errors,
                'fields' => $_POST
            ]);
        }

    }

    // Detruit la session et déconnecte l'utilisateur
    public function logout() {
        unset($_SESSION['user']);
        $_SESSION = [];

        session_destroy();

        $this->redirect('home');
    }
    
}