<?php

namespace MyBlog\Controllers;

class BlogController extends CoreController {
    
    public function list() {

        // Récup la liste des posts en db
        $list = \MyBlog\Models\PostModel::findAll();

        // On affiche le template
        echo $this->templates->render('blog/list', [
            'title' => 'Blog', 
            'posts' => $list
        ]);
    }

    public function read($params) {
        // Slug du post à afficher
        $slug = $params['slug'];

        // Récup du post
        $post = \MyBlog\Models\PostModel::findBySlug($slug);

        // On affiche le template
        echo $this->templates->render('blog/read', ['post' => $post]);
    }

}