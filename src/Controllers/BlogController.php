<?php

namespace MyBlog\Controllers;

class BlogController extends CoreController {
    
    public function list() {
        echo $this->templates->render('blog/list', ['title' => 'Blog']);
    }

    public function read($params) {
        // Id du post à afficher
        $postId = $params['id'];

        echo $this->templates->render('blog/read', ['id' => $postId]);
    }

}