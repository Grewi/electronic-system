<?php 
namespace app\controllers\admin;
use app\models\user_role;
use app\controllers\admin\controller;
use electronic\core\view\view;

class userRoleController extends controller
{
    public function index()
    {
        $roles = user_role::all();
        $this->title(lang('admin', 'userRoles'));
        $this->bc(lang('admin', 'userRoles'));
        $this->data['roles'] = $roles;
        $this->data['rolesSubMenu'] = true;
        new view('admin/userRole/index', $this->data);
    }

    public function create()
    {
        $this->title(lang('admin', 'createRole'));
        $this->bc(lang('admin', 'userRoles'), '/' . ADMIN . '/roles');
        $this->bc(lang('admin', 'createRole'));
        new view('admin/userRole/create', $this->data);
    }

    public function update()
    {
        $this->title(lang('admin', 'editRole'));
        $this->bc(lang('admin', 'userRoles'), '/' . ADMIN . '/roles');
        $this->bc(lang('admin', 'editRole'));
        new view('admin/userRole/update', $this->data);
    }

    public function delete()
    {
        $this->title(lang('admin', 'deleteRole'));
        $this->bc('admin', '/admin');
        $this->bc(lang('admin', 'userRoles'), '/' . ADMIN . '/roles');
        $this->bc(lang('admin', 'deleteRole'));
        new view('admin/userRole/delete', $this->data);
    }
}
