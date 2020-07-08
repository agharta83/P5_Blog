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
            'title' => htmlspecialchars($headTitle),
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
     * Affiche la page "Blog" avec la liste des posts publiés
     *
     * @return void
     */
    public function blogList($params)
    {

        // Récup la liste des posts en db
        $pagination = $this->postManager->findAllPostsPublishedAndPaginated(6, (int) $params['page']);

        $results = $pagination->getCurrentPageResults();

        $posts = [];

        // On parcourt le tableau de résultat et on génére l'objet PostModel
        foreach ($results as $row) {
            $postId = $row['id'];
            $posts[$postId] = $this->postManager->buildObject($row);
        }

        // On affiche le template
        return $this->renderView('blog/list', [
            'title' => 'Blog',
            'posts' => $posts,
            'pagination' => $pagination
        ]);
    }

    /**
     * Affiche la page d'un article
     *
     * @param array $params
     * @return void
     */
    public function blogRead($params)
    {

        // Slug du post à afficher
        $slug = $params['slug'] ?? $params;

        // Récup du post
        $post = $this->postManager->findBySlug($slug);

        // Recup des commentaires
        $comments = $this->commentManager->findValidCommentsForPost($post->getId());
        // Recup du nombre de commentaires
        $nbComments = $this->commentManager->countNbCommentsForPost($post->getId());
        // Récup des posts similaires
        $similarPosts = $this->postManager->findByCategory($post->getCategory(), $post->getSlug());

        // On affiche le template
        echo $this->templates->render('blog/read', [
            'post' => $post,
            'comments' => $comments,
            'nbComments' => $nbComments,
            'similarPosts' => $similarPosts,
            'currentPage' => $params['page']
        ]);
    }

    /**
     * Affiche la liste des projets
     *
     * @return void
     */
    public function projectList()
    {
        echo $this->templates->render('portfolio/list', ['title' => 'Portfolio']);
    }

    /**
     * Affiche la page d'un projet
     *
     * @param array $params
     * @return void
     */
    public function projectRead($params)
    {
        // Id du projet
        $projectId = $params['id'];

        echo $this->templates->render('portfolio/read', ['id' => $projectId]);
    }

    /**
     * Ajoute un commentaire ainsi qu'un utilisateur et redirige sur le post commenté
     *
     * @return void
     */
    public function addComment()
    {

        $post = $this->post;

        if (!empty($post)) {
            // On récup l'id du post
            $postId = $post->getParameter('post_id');

            // On va check si l'utilisateur existe 
            // et on le créé en BDD si besoin
            $user = $this->userManager->addUser($post);

            // On enregistre l'user en session
            $this->saveUserInSession($user);

            // On insére le commentaire en BDD
            $this->commentManager->addComment($post, $user);

            // On récup le slug du post
            $postSlug = $this->postManager->findById($postId)->getSlug();

            $this->blogRead($postSlug);
        }
    }

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
                $isValid = password_verify($post->getParameter('password'), $hash); // TODO A tester

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

            echo $this->templates->render('main/home', [
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

    /**
     * Enregistre les infos de l'utilisateur en session
     *
     * @param UserModel $user
     * @return Session
     */
    public function saveUserInSession(UserModel $user)
    {

        $this->session->set('user', [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'login' => $user->getLogin(),
            'firstname' => $user->getFirstname(),
            'lastname' => $user->getLastname(),
            'avatar' => $user->getAvatar(),
            'is_admin' => (bool) $user->isAdmin()
        ]);
    }

}
