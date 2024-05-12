<?php 
namespace app\controllers\users;

use app\models\users;
use app\models\user_role;
use app\controllers\controller;
use electronic\core\view\view;
use electronic\core\lang\lang;
use electronic\core\validate\validate;

class registerController extends controller
{
    public function index()
    {
        $this->title(lang::register('title'));
        $userRole = null;
        if(user_id() > 0){
            $user = (new users)->find(user_id());
            $userRole = (new user_role)->find($user->user_role_id);
        }
        $this->data['userRole'] = $userRole;
        new view('users/register/register', $this->data);
    }

    public function register()
    {
        $valid = new validate();
        $valid->name('csrf')->csrf('register');
        $valid->name('loginUser')->latRuInt()->empty()->strlenMin(3)->unique('users', 'login');
        $valid->name('emailUser')->mail()->empty()->unique('users', 'email');
        $valid->name('pass')->empty()->strlenMin(5)->pass();       
        $valid->name('confirm')->confirmPass();

        if($valid->control()){
            $userRole = (new user_role)->where('slug', 'user')->get();
            $data = [
                'email' => $valid->return('emailUser'),
                'email_code' => rand(1000, 9999),
                'email_status' => 0,
                'password' => $valid->return('pass'),
                'login' => $valid->return('loginUser'),
                'active' => 1,
                'user_role_id' => $userRole->id,
            ];
            $user = (new users)->insert($data);
            alert2('Спасибо за регистрацию!', 'primary');
            $login = new \system\core\user\auth();
            $login->setCsrf(false);
            $login->setPass($_POST['pass']);
            $login->setEmail($user->email);
            $login->setLogin($user->login);
            $login->redirect(referal_url());
            $login->login(function($auth, $user, $valid){
                if($valid->control()){
                    redirect('/user');
                }else{
                    redirect(referal_url(), $valid->data(), $valid->error());
                }
            });
        }else{
            redirect(referal_url(), $valid->data(), $valid->error());
        }

        
    }
}
