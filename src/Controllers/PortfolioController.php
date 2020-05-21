<?php

namespace MyBlog\Controllers;

class PortfolioController extends CoreController {
    
    public function list() {
        echo $this->templates->render('portfolio/list', ['title' => 'Portfolio']);
    }

    public function read($params) {
        // Id du projet
        $projectId = $params['id'];

        echo $this->templates->render('portfolio/read', ['id' => $projectId]);
    }
    
}