<?php

namespace MyBlog\Controllers;

class UserController extends CoreController
{
   /**
     * Connexion à l'administration
     *
     * @return Object|Array UserModel|Errors
     */
    public function login()
    {

        $errors = [];

        if (!empty($this->post)) {
            $post = $this->post;

            // On identifie l'utilisateur grâce à son login
            $login = $post->getParameter('login');
            $user = $this->userManager->findByLogin($login);

            if (!$user) {
                $errors[] = "Utilisateur inconnu";
            } else {
                // On teste le mot de passe
                $hash = $user->getPassword();
                $isValid = password_verify($post->getParameter('password'), $hash);

                if (!$isValid) {
                    $errors[] = "Mot de passe incorrect";
                } else {
                    // On enregistre les infos de l'user en session
                    $this->saveUserInSession($user);
                    // On redirige l'utilisateur
                if (count($errors) === 0) $this->redirect('dashboard');
                }
            }

            $headTitle = 'Audrey César | Portfolio Blog';

            return $this->renderView('main/home', [
                'title' => $headTitle,
                'errors' => $errors,
                'fields' => $post
            ]);
        }
    }

    /**
     * Permet de se déconnecter et donc détruire la session
     *
     * @return void
     */
    public function logout()
    {
        $this->session->remove('user');

        $this->session->set('user', []);

        $this->session->stop();

        $this->redirect('home');
    }

    // TODO Faire une vérif en ajax
    /**
     * Fait les vérifications et appelle la méthode du manager pour réinitialiser le mot de passe
     *
     * @return void
     */
    public function resetPassword()
    {
        $post = $this->post;

        if (isset($post) && !empty($post)) {
            $user = $this->userManager->findByLogin($post->getParameter('login'));

            if (!$user) {
                $errors[] = "Utilisateur inconnu";
            } else {
                // On regarde si les mots de passe sont identiques
                if ($post->getParameter('password') === $post->getParameter('password2')) {
                    // On enregistre le nouveau mot de passe
                    $this->userManager->resetPassword($post->getParameter('password'), $post->getParameter('login'));
                } else {
                    $errors[] = "Les mots de passe ne sont pas identiques";
                }

                // On redirige l'utilisateur
                if (count($errors) === 0) $this->redirect('dashboard');
            }
        }
    }
}