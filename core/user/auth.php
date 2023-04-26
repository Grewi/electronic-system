<?php
namespace system\core\user;
use system\core\validate\validate;
use system\core\logs\logs;
use system\core\request\request;
use system\core\traits\singleton;
use system\core\config\config;

class auth
{
    use singleton;

    static private $connect;
    public $status;
    private $session_time = 60 * 60 * 24;
    private $urlFailed = null;
    private $urlSuccess = null;


    /**
     * @var  Вход пользователя по почте
     * 
     */
    protected function login($email = null, $pass = null): void
    {
        $valid = new validate();
        if (!is_null($email) && !is_null($pass)) {
            $valid->name('email', $email)->mail()->empty();
            $valid->name('password', $pass)->empty();
            //$valid->name('csrf')->csrf('auth')->empty();
        } else {
            $valid->name('email')->mail()->empty();
            $valid->name('password')->empty();
            $valid->name('csrf')->csrf('auth')->empty();
        }

        $user  = ($valid->control()) ? db()->fetch('SELECT * FROM `users` WHERE `email` = :email', ['email' => $valid->return('email')]) : false;
        if ($valid->control() && $user && password_verify($valid->return('password'), is_null($user->password) ? '' : $user->password)) 
        {

            $passForCook = bin2hex(random_bytes(15)); //временный хеш сессии
            $date        = date('U'); // Дата сессии

            $param = [
                'user_id'     => $user->id,
                'session_key' => $passForCook,
                'active_time' => $date
            ];
            db()->query('INSERT INTO `sessions` SET `user_id` = :user_id, `session_key` = :session_key , `active_time` = :active_time', $param);

            setcookie('us', $passForCook, date('U') + $this->session_time(), '/');
            $_SESSION['us'] = $passForCook;
            $logs = [
                'ip' => request::get('global')->ip,
                'browser_family' => $_SESSION['browser_family'],
                'device_name' => $_SESSION['device_name'],
                'device_type' => $_SESSION['device_type'],
                'os_name' => $_SESSION['os_name'],
            ];
            $text = '<ul>
                <li>ip - ' . $logs['ip'] . '</li>
                <li>browser_family - ' . $logs['browser_family'] . '</li>
                <li>device_type - ' . $logs['device_type'] . '</li>
                <li>os_name - ' . $logs['os_name'] . '</li>
            </ul>';
            logs::userId($user->id)->name('auth', 'Авторизация пользователя')->description($text)->insert($logs, 'auth');
            redirect($this->urlSuccess ? $this->urlSuccess : referal_url());
        } else {
            $error = [
                'email' => 'Введённые данные не верны!',
            ];
            alert2('Войти не удалось!', 'danger', '');
            redirect($this->urlFailed ? $this->urlFailed : referal_url(), $valid->data(), $error);
        }
    }

    /**
     * 
     * @var Выход пользователя
     */
    protected function out(string $url = ''): void
    {
        logs::name('exit', 'Выход пользователя')->insert();
        db()->query('DELETE FROM `sessions` WHERE `session_key` = :session_key', ['session_key' => $_SESSION['us']]);
        unset($_SESSION['us']);
        unset($_SESSION['user']);
        setcookie('us', '', 1, '/');
        header('Location: ' . $url);
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
            if (isset($ses->user_id)) {
                //При активности пользователя, продлеваем сессию
                db()->query('UPDATE `sessions` SET `active_time` = :active_time WHERE `id` = ' . $ses->id, ['active_time' => time()]);
                $result = $ses->user_id; // Актуальная сессия
                $this->delOldSes($ses->user_id);
            } else {
                $result = '0'; // Сессия завершенна
            }
        } elseif (isset($_COOKIE['us'])) {
            //Если есть только куки
            //Проверяем актуальность кук,
            $ses = db()->fetch('SELECT * FROM `sessions` WHERE `session_key` = :session_key', ['session_key' => $coockie]);
            if (isset($ses->session_key)) {
                //востанавливаем сессию, 
                $_SESSION['us'] = $ses->session_key;
                $result = $ses->user_id; // Востановленная сессия
                //Обновляем дату
                db()->query('UPDATE `sessions` SET `active_time` =  :active_time WHERE `id` = :id', ['active_time' => date('U'), 'id' =>  $ses->id]);
                $this->delOldSes($ses->user_id);
            } else {
                $result = '0'; // Востановить ссесию невозможно
            }
        } else {
            $result = '0'; // Требуется авторизация
        }
        $this->status = $result;
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
        if($globalConfig > 0){
            return (int)$globalConfig;
        }else{
            return $this->session_time;
        }
    }
}
