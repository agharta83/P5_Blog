<?php

namespace MyBlog\Controllers;

class PortfolioController extends CoreController {
    
    public function list() {
        echo $this->templates->render('main/portfolio', ['title' => 'Portfolio']);
    }
    
}