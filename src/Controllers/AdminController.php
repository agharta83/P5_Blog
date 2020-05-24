<?php

namespace MyBlog\Controllers;

class AdminController extends CoreController {

    public function home() {

        $headTitle = 'Dashboard';

        // On affiche le template
        echo $this->templates->render('admin/home', ['title' => $headTitle]);
    }

}