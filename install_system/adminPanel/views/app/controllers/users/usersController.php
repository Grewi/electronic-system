<?php 
namespace app\controllers\users;
use app\controllers\controller;
use electronic\core\view\view;

class usersController extends controller
{
    public function index()
    {
        $this->title('');
        new view('users/users/index', $this->data);
    }

    public function create()
    {
        $this->title('');
        new view('users/users/create', $this->data);
    }

    public function update()
    {
        $this->title('');
        new view('users/users/update', $this->data);
    }

    public function delete()
    {
        $this->title('');
        new view('users/users/delete', $this->data);
    }
}
