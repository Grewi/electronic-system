<?php

namespace app\controllers\index;

use app\controllers\controller;
use electronic\core\view\view;

class indexController extends controller
{

    public function index()
    {
        $this->title('Главная страница');
        new view('index/index', $this->data);
    }

}