<?php

namespace MyBlog\Controllers;

use MyBlog\Managers\CommentManager;
use MyBlog\Managers\PostManager;
use MyBlog\Managers\UserManager;
use MyBlog\Services\Request;
use Myblog\Services\Parameter;
use MyBlog\Services\Uploader;
use MyBlog\Models\UserModel;

/**
 * Controller Mere servant à instancier le Router, les Managers et le templating
 * il permet de définir des instances et variables globales étendues aux classes enfants
 */
abstract class CoreController {
    
    /**
     * CoreController constructor
     *
     * @param \AltoRouter $router
     */
    public function __construct(\Altorouter $router, $templates) {

        // On enregistre le router dans le controller
        $this->router = $router;

        // Instance de Plates pour gérer les templates
        //$this->templates = new \League\Plates\Engine( __DIR__ . '/../Views' );
        $this->templates = $templates;

        // Instance de la classe Request
        $this->request = new Request();
        $this->get = $this->request->getRequest();
        $this->post = $this->request->postRequest();
        $this->files = $this->request->filesRequest();
        $this->session = $this->request->sessionRequest();

        // On instancie les Managers
        $this->postManager = new PostManager();
        $this->commentManager = new CommentManager();
        $this->userManager = new UserManager();

        // On enregistre les informations de l'utilisateur connecté
        $this->currentUser = $this->userManager->getUserConnected();

        // Données globales accessibles dans les vues
        $this->templates->addData([
            'basePath' => $_SERVER['BASE_URI'],
            'router' => $this->router,
            'user' => $this->currentUser,
            'userManager' => $this->userManager,
            'postManager' => $this->postManager,
            'commentManager' => $this->commentManager,
            'session' => $this->session
        ]);

    }

    /**
     * Permet de faire une redirection
     *
     * @param string $routeName
     * @param array $infos
     * @return void
     */
    public function redirect ($routeName, $infos = []) {
        header('Location: ' . $this->router->generate($routeName, $infos));
        exit();
    }

    /**
     * Permet de fournir la vue passée en paramétre ainsi que les variables nécessaires
     *
     * @param string $viewname
     * @param array $variables
     * @return void
     */
    public function renderView(string $viewname, array $variables = [])
    {
        echo $this->templates->render($viewname, $variables);
    }

    /**
     * Permet d'upload l'image
     *
     * @param Parameter $files
     * @return void
     */
    protected function upload(Parameter $files)
    {
        if (null !== $files->getParameter('name') && !empty($files->getParameter('name'))) {
            $this->checkFiles($files);

            // On upload
            $uploader = new Uploader();
            $uploadResult = $uploader->upload($files->getParameter('files'));


            if ($uploadResult !== TRUE) {
                echo 'Impossible d\'enregistrer l\'image.';
            }

            return $uploadResult;
        } 
        
        return null;
        
    }

    /**
     * Permet de vérifier si il y a un fichier à upload
     *
     * @param Parameter $files
     * @return Exception
     */
    private function checkFiles(Parameter $files)
    {
        // On check $_FILES
        try {
            if (!$files) {
                throw new \UnexpectedValueException('Un problème est survenu pendant le téléchargement. Veuillez réessayer.');
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            exit();
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
            'is_admin' => (bool) $user->isAdmin()
        ]);
    }
    
}