<?php

namespace MyBlog\Controllers;

class BlogController extends CoreController {
    
    public function list() {
        echo $this->templates->render('main/blog', ['title' => 'Blog']);
    }

}