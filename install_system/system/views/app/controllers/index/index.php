<?php

namespace app\controllers\index;

use app\models\users;
use app\models\user_role;
use app\controllers\controller;
use electronic\core\view\view;

class indexController extends controller
{

    public function index()
    {
        $userRole = null;
        if(user_id() > 0){
            $user = users::find(user_id());
            $userRole = user_role::find($user->user_role_id);
        }
        $this->data['userRole'] = $userRole;
        $this->title('Главная страница');
        new view('index/index', $this->data);
    }

}