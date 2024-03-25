<?php 
namespace app\controllers\admin;
use app\controllers\admin\controller;
use electronic\core\view\view;

class adminController extends controller
{
    public function index()
    {
        $this->title('');
        new view('admin/admin/index', $this->data);
    }

    public function create()
    {
        $this->title('');
        new view('admin/admin/create', $this->data);
    }

    public function update()
    {
        $this->title('');
        new view('admin/admin/update', $this->data);
    }

    public function delete()
    {
        $this->title('');
        new view('admin/admin/delete', $this->data);
    }
}
