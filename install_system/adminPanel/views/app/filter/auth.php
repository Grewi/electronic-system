<?php
namespace app\filter;

class auth
{
    public function index()
    {

        if(isset($_POST['email']) && isset($_POST['pass']) && isset($_POST['auth'])){
            $login = new \system\core\user\auth();
            $login->setPass($_POST['pass']);
            $login->setEmail($_POST['email']);
            $login->setLogin($_POST['login']);
            $login->redirect(referal_url());
            $login->login(function($auth, $user, $valid){
                if($valid->control()){
                    redirect(referal_url());
                }else{
                    // dd($valid);
                    redirect(referal_url(), $valid->data(), $valid->error());
                }
            });
        }

        if(isset($_REQUEST['exit'])){
            $login = new \system\core\user\auth();
            $login->redirect('/');
            $login->out();
        }


    }
}