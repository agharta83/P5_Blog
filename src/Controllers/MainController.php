<?php

namespace MyBlog\Controllers;

use MyBlog\Models\UserModel;

/**
 * Classe permettant d'afficher et de piloter les pages publiques
 */
class MainController extends CoreController
{

    /**
     * Retourne la page d'accueil
     *
     * @return void
     */
    public function home()
    {
        // Recup des derniers posts publiés
        $posts = $this->postManager->findLastPublishedPost();

        // Render template
        $headTitle = 'Audrey César | Portfolio Blog';

        return $this->renderView('main/home', [
            'title' => $headTitle,
            'posts' => $posts
        ]);
    }

    /**
     * Retourne la page "About"
     *
     * @return void
     */
    public function about()
    {
        return $this->renderView('main/about', ['title' => 'about']);
    }

    /**
     * Retourne la page "Contact"
     *
     * @return void
     */
    public function contact()
    {
        return $this->renderView('main/contact', ['title' => 'contact']);
    }
    
    /**
     * Formulaire de contact
     *
     * @return void
     */
    public function contactForm()
    {
        $post = $this->post;

        $name = $post->getParameter('name');
        $email = $post->getParameter('email');
        $message = $post->getParameter('message');

        $errors = [];

        $errors = isset($name) && empty($name) ? 'Veuillez saisir votre nom' : false;
        $errors = isset($email) && empty($email) ? 'Veuillez saisir une adresse mail valide' : null;
        $errors = isset($message) && empty($message) ? 'Veuillez saisir un message' : null;

        if (!$errors) {

            $this->userManager->sendEmail($name, $email, $message);

            $message = 'Le formulaire à bien été envoyé.';

            $this->home();
        }
    }

}
