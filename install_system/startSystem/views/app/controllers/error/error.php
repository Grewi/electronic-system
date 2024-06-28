<?php
namespace app\controllers\error;

use app\controllers\controller;
use electronic\core\view\view;
use system\core\error\error404;

class error extends controller
{
    use error404;

    public function error404()
    {
        $this->errorResponse();
        new view('error/error404', $this->data);
    }
}