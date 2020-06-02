<?php

namespace MyBlog\Controllers;

use MyBlog\Services\Uploader;

class AdminController extends CoreController {

    public function home() {

        $headTitle = 'Dashboard';

        // On récupére les datas à afficher (posts, projets, commentaires, users)
        // TODO afficher aussi des notifs pour les posts en brouillon, et les commentaires à valider
        $nbPublishedPosts = \MyBlog\Models\PostModel::countNbPublishedPost();

        // On insére les datas dans un tableau
        $countDatas = [
            'posts' => $nbPublishedPosts
        ];


        // On affiche le template
        echo $this->templates->render('admin/home', [
            'title' => $headTitle,
            'countDatas' => $countDatas
        ]);
    }

    public function list () {

        // Récup la liste des posts en db
        $posts = \MyBlog\Models\PostModel::findAllPosts();

        $headTitle = 'Dashboard / Posts';

        // On affiche le template
        echo $this->templates->render('admin/posts', [
            'title' => $headTitle, 
            'posts' => $posts
        ]);
    }

    // Création d'un post
    public function createNewPost() {

        if (!empty($_POST)) {
            $post = new \MyBlog\Models\PostModel();

            $post->setCategory($_POST['category']);
            $post->setTitle($_POST['titre']);
            $post->setChapo($_POST['chapo']);
            $post->setcontent($_POST['content']);

            // On check $_FILES
            try {
                if (!$_FILES) {
                    throw new \UnexpectedValueException('Un problème est survenu pendant le téléchargement. Veuillez réessayer.');
                }
            } catch (\Exception $e) {
                echo $e->getMessage();
                exit();
            }

            // On upload
            $uploader = new Uploader(); // TODO le fichier ne s'enregistre pas dans /uploads
            $uploadResult = $uploader->upload($_FILES['files']);

            
            if ($uploadResult !== TRUE) {
                echo 'Impossible d\'enregistrer l\'image.';
            }
            

            $post->setImg($_FILES['files']['name'][0]);
            $post->setCreated_on(date("Y-m-d"));
            $post->setSlug($_POST['titre']); // TODO les ' / " ne se supprime pas, revoir la regexp
            $post->setNumber_reviews(0);
            $post->setUser_id('1'); // TODO Faire la requete / méthode pour retrouver l'user id quand la partie authentification sera codée

            if (isset($_POST['published']) && !empty($_POST['published'] && $_POST['published'] == 'on')) {
                $post->setPublished_date(date("Y-m-d"));
                $post->setPublished(1);
            } else if (!isset($_POST['published'])) {
                $post->setPublished(0);
            }

            var_dump($post); die();

            // On enregistre
            //var_dump($post->save()); die(); // Si renvoie 00000 => c'est ok
            $post->save();

            // On redirige
            $this->redirect('admin_blog_list');

        } else {
            $headTitle = 'Dashboard / Nouveau post';

            echo $this->templates->render('admin/new_post', [
                'title' => $headTitle
            ]);
        }

    }

}