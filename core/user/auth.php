<?php

namespace system\core\user;

use system\core\validate\validate;
use system\core\user\bruteforce;
use system\core\request\request;
use system\core\traits\singleton;
use system\core\config\config;

class auth
{
    use singleton;

    static private $connect;
    public $status;
    private $session_time = 60 * 60 * 24;
    private $loginRegex = "/^[\s a-zA-Z0-9а-яА-ЯёЁ.,\(\)$@!?#=+\-_]+$/u";
    private $urlFailed = null;
    private $urlSuccess = null;
    private $login;
    private $email;
    private $pass;
    public $error;



    protected function setLogin($login)
    {
        $this->login = $login;
    }

    protected function setEmail($email)
    {
        $this->email = $email;
    }

    protected function setPass($pass)
    {
        $this->pass = $pass;
    }

    protected function setLoginRegex($regex)
    {
        $this->loginRegex = $regex;
    }

    /**
     * @var  Вход пользователя по почте
     * 
     */
    protected function login($function = null): void
    {
        $valid = new validate();
        $where = [];  
        $bild = [];
        if ($this->email) {
            $valid->name('email', $this->email)->mail()->empty();
            $where[] = '`email` = :email';
            $bild['email'] = $valid->return('email');
        } 
        if($this->login){
            $valid->name('login', $this->login)->free($this->loginRegex)->empty();
            $where[] = '`login` = :login';
            $bild['login'] = $valid->return('login');
        }
        $valid->name('password', $this->pass)->empty();
        $valid->name('csrf')->csrf('auth')->empty();   
        
        $bruteforce = new bruteforce();
        $bruteforce->addTry();

        $user = !empty($where) ? db()->fetch('SELECT * FROM `users` WHERE ' . implode(' AND ', $where), $bild) : null;

        if ($valid->control() && $user && password_verify($valid->return('password'), is_null($user->password) ? '' : $user->password) && $bruteforce->status()) {
            $bruteforce->resetTry();
            $passForCook = bin2hex(random_bytes(15)); //временный хеш сессии
            $date        = date('U'); // Дата сессии

            $param = [
                'user_id'     => $user->id,
                'session_key' => $passForCook,
                'active_time' => $date,
                'user_agent' => request('global')->user_agent,
                'ip' => request('global')->ip,
            ];
            db()->query('INSERT INTO `sessions` SET `user_id` = :user_id, `session_key` = :session_key , `active_time` = :active_time, `user_agent` = :user_agent, `ip` = :ip', $param);

            setcookie('us', $passForCook, date('U') + $this->session_time(), '/');
            $_SESSION['us'] = $passForCook;
            $this->status = $user->id;
            if ($function) {
                $function($this, $user, $valid);
            }
            if($this->urlSuccess){
                redirect($this->urlSuccess);
            }

        }else{
            $this->status = 0;
            if ($function) {
                $function($this, $user, $valid);
            }
            if($this->urlFailed){
                redirect($this->urlFailed);
            }         
        }
    }

    /**
     * 
     * @var Выход пользователя
     */
    protected function out($function = null): void
    {
        db()->query('DELETE FROM `sessions` WHERE `session_key` = :session_key', ['session_key' => $_SESSION['us']]);
        unset($_SESSION['us']);
        unset($_SESSION['user']);
        setcookie('us', '', 1, '/');
        if ($function) {
            $function();
        }
        if($this->urlFailed){
            redirect($this->urlFailed);
        }elseif($this->urlSuccess){
            redirect($this->urlSuccess);
        }else{
            redirect('/');
        }
    }

    // возвращает id пользователя или 0 если не зарегистрирован
    protected function status(): string
    {
        $session = isset($_SESSION['us']) ? $_SESSION['us'] : null;
        $coockie = isset($_COOKIE['us']) ? $_COOKIE['us'] : null;

        if (isset($session) && isset($coockie) && $session == $coockie) {
            //Если есть и сессия, и куки 
            //Проверяем актуальность кук и сессии
            $ses = db()->fetch('SELECT * FROM `sessions` WHERE `session_key` = :session_key', ['session_key' => $coockie]);
            if (isset($ses->user_id) && $this->sanitary($ses)) {
                //При активности пользователя, продлеваем сессию
                db()->query('UPDATE `sessions` SET `active_time` = :active_time WHERE `id` = ' . $ses->id, ['active_time' => time()]);
                $result = $ses->user_id; // Актуальная сессия
                $this->delOldSes($ses->user_id);
            } else {
                $this->error = 'Сессия завершенна';
                $result = '0'; // Сессия завершенна
            }
        } elseif (isset($_COOKIE['us'])) {
            //Если есть только куки
            //Проверяем актуальность кук,
            $ses = db()->fetch('SELECT * FROM `sessions` WHERE `session_key` = :session_key', ['session_key' => $coockie]);
            if (isset($ses->session_key)  && $this->sanitary($ses)) {
                //востанавливаем сессию, 
                $_SESSION['us'] = $ses->session_key;
                $result = $ses->user_id; // Востановленная сессия
                //Обновляем дату
                db()->query('UPDATE `sessions` SET `active_time` =  :active_time WHERE `id` = :id', ['active_time' => date('U'), 'id' =>  $ses->id]);
                $this->delOldSes($ses->user_id);
            } else {
                $this->error = 'Востановить ссесию невозможно';
                $result = '0'; // Востановить ссесию невозможно
            }
        } else {
            $this->error = 'Требуется авторизация';
            $result = '0'; // Требуется авторизация
        }
        $this->status = $result;
        // dd($this->error, $result);
        return $result;
    }

    private function delOldSes($user_id = null): void
    {
        //проверяем актуальность всех сессий
        db()->query('DELETE FROM `sessions` WHERE `active_time` < :active_time', ['active_time' => $this->session_time]);

        //Разрешаем одному пользователю только одну сессию.
        // if ($user_id) {
        //     $data = [
        //         'session_key' => $_SESSION['us'],
        //         'user_id'     => $user_id
        //     ];
        //     db()->query('DELETE FROM `sessions` WHERE `session_key` != :session_key AND `user_id` = :user_id', $data);
        // }
    }

    protected function sanitary($ses)
    {
        if ($ses->user_agent && $ses->user_agent == request('global')->user_agent) {
            return true;
        } elseif (is_null($ses->user_agent) && is_null(request('global')->user_agent)) {
            return true;
        } else {
            return false;
        }
    }

    protected function redirectFailed(string $url)
    {
        $this->urlFailed = $url;
        return $this;
    }

    protected function redirectSuccess(string $url)
    {
        $this->urlSuccess = $url;
        return $this;
    }

    protected function redirect(string $url)
    {
        $this->urlSuccess = $url;
        $this->urlFailed = $url;
        return $this;
    }

    /**
     *Время жизни сессии
     */
    private function session_time()
    {
        $globalConfig = config::globals('session_time');
        if ($globalConfig > 0) {
            return (int)$globalConfig;
        } else {
            return $this->session_time;
        }
    }
}
