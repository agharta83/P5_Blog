<?php

namespace MyBlog\Controllers;

class MainController extends CoreController {

    public function home() {
        // Render template
        $headTitle = 'mon titre test';
        echo "c'est la home";
        //echo $this->templates->render('main/home', ['title' => $headTitle]);
    }

    public function about() {
        echo $this->templates->render('main/about', ['title' => 'about']);
    }

    public function contact() {
        echo $this->templates->render('main/contact');
    }
    
}