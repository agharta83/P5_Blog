<?php

namespace MyBlog\Controllers;

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

    public function createNewPost() {

        if (!empty($_POST)) {
            $post = new \MyBlog\Models\PostModel();

            $post->setCategory($_POST['category']);
            $post->setTitle($_POST['titre']);
            $post->setChapo($_POST['chapo']);
            $post->setcontent($_POST['content']);
            // $post->setImg($_POST['img']); // TODO Faire le traitement pour les images !
            $post->setCreated_on(date("Y-m-d"));
            $post->setSlug($_POST['titre']);
            $post->setNumber_reviews(0);
            $post->setUser_id('1'); // TODO Faire la requete / méthode pour retrouver l'user id quand la partie authentification sera codée

            if (isset($_POST['published']) && !empty($_POST['published'] && $_POST['published'] == 'on')) {
                $post->setPublished_date(date("Y-m-d"));
                $post->setPublished(1);
            } else if (!isset($_POST['published'])) {
                $post->setPublished(0);
            }

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