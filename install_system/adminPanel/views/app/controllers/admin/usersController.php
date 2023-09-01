<?php 
namespace app\controllers\admin;

use app\models\users;
use app\models\user_role;
use app\controllers\admin\controller;
use electronic\core\view\view;
use electronic\core\validate\validate;

class usersController extends controller
{
    public function index()
    {
        $users = users::pagin();
        $this->title(lang('admin', 'users'));
        
        $this->bc(lang('admin', 'users'));
        $this->data['users'] = $users->all();
        $this->data['pagin'] = $users->pagination();
        $this->data['userSubMenu'] = true;
        new view('admin/users/index', $this->data);
    }

    public function create()
    {
        $userRoles = user_role::all();
        $this->title(lang('admin', 'createUser'));
        $this->bc(lang('admin', 'users'), '/' . ADMIN . '/users');
        $this->bc(lang('admin', 'createUser'));
        $this->data['userSubMenu'] = true;
        $this->data['userRoles'] = $userRoles;
        new view('admin/users/create', $this->data);
    }

    public function createAction()
    {
        $valid = new validate();
        $valid->name('csrf')->csrf('userCreate');
        $valid->name('email')->mail()->unique('users', 'email')->empty();
        $valid->name('password')->empty()->pass();
        $valid->name('login')->latRuInt()->unique('users', 'login')->empty();
        $valid->name('active')->bool();
        $valid->name('user_role_id')->isset('user_role')->empty();

        if($valid->control()){
            $data = [
                'email' => $valid->return('email'),
                'email_code' => rand(1000, 9999),
                'email_status' => 0,
                'password' => $valid->return('password'),
                'login' => $valid->return('login'),
                'active' => $valid->return('active'),
                'user_role_id' => $valid->return('user_role_id'),
            ];

            users::insert($data);
            alert2(lang('admin', 'successSave'), 'success');
            redirect(referal_url());
        }else{
            alert2(lang('admin', 'errorSave'), 'danger');
            redirect(referal_url(), $valid->data(), $valid->error());
        }
    }

    public function update()
    {
        $user = users::find(request('get')->user_id);
        $userRoles = user_role::all();
        $this->title(lang('admin', 'editUser'));
        $this->bc(lang('admin', 'users'), '/' . ADMIN . '/users');
        $this->bc(lang('admin', 'editUser'));
        $this->data['userSubMenu'] = true;
        $this->data['user'] = $user;
        $this->data['userRoles'] = $userRoles;
        new view('admin/users/update', $this->data);
    }

    public function updateAction()
    {
        $user = users::find(request('get')->user_id);
        $valid = new validate();
        $valid->name('csrf')->csrf('userUpdate');
        $valid->name('email')->mail()->unique('users', 'email', $user->id)->empty();
        $valid->name('email_code')->int()->empty();
        $valid->name('email_status')->bool();
        $valid->name('password')->pass();
        $valid->name('login')->latRuInt()->empty()->unique('users', 'login', $user->id);
        $valid->name('active')->bool();
        $valid->name('user_role_id')->isset('user_role')->empty();

        if($user && $valid->control()){

            $user->email = $valid->return('email');
            $user->email_code = $valid->return('email_code');
            $user->email_status = $valid->return('email_status');
            $user->login = $valid->return('login');
            $user->active = $valid->return('active');
            $user->user_role_id = $valid->return('user_role_id');
            if(isset($_POST['password'])){
                $user->password = $valid->return('password');
            }

            $user->save();

            alert2(lang('admin', 'successSave'), 'success');
            redirect(referal_url());
        }else{
            alert2(lang('admin', 'errorSave'), 'danger');
            redirect(referal_url(), $valid->data(), $valid->error());
        }
    }

    public function delete()
    {
        $user = users::find(request('get')->user_id);
        $this->title(lang('admin', 'deleteUser'));
        $this->bc(lang('admin', 'users'), '/' . ADMIN . '/users');
        $this->bc(lang('admin', 'deleteUser'));
        $this->data['userSubMenu'] = true;
        $this->data['user'] = $user;
        new view('admin/users/delete', $this->data);
    }

    public function deleteAction()
    {
        $user = users::find(request('get')->user_id);
        try{
            users::where($user->id)->delete();
            redirect('/admin/users');
        }catch(\Exception $e){
            redirect(referal_url());
        }
    }
}
