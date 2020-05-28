<?php

namespace MyBlog\Controllers;

class AdminController extends CoreController {

    public function home() {

        $headTitle = 'Dashboard';

        // On affiche le template
        echo $this->templates->render('admin/home', ['title' => $headTitle]);
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

}