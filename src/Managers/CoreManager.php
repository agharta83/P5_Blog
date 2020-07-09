<?php

namespace MyBlog\Managers;

use Myblog\Services\Request;

// Il va falloir faire un CoreManager pour pouvoir accéder à la session
class CoreManager extends Database {

    protected static $tableName;

    public function getSession()
    {
        $request = new Request();
         return $request->sessionRequest();
    }

}