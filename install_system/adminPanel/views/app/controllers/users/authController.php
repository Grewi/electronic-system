<?php 
namespace app\controllers\users;
use app\models\users;
use app\controllers\controller;
use electronic\core\view\view;

class authController extends controller
{
    public function indexUser()
    {
        $user = users::find(user_id());
        $this->title('');
        $this->data['user'] = $user;
        new view('users/auth/indexUser', $this->data);
    }

    public function indexGoust()
    {
        $this->title('');
        new view('users/auth/indexGoust', $this->data);
    }

    public function create()
    {
        $this->title('');
        new view('users/auth/create', $this->data);
    }

    public function update()
    {
        $this->title('');
        new view('users/auth/update', $this->data);
    }

    public function delete()
    {
        $this->title('');
        new view('users/auth/delete', $this->data);
    }
}
