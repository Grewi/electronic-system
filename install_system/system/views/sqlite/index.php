<?php
define('INDEX', true);
define('ROOT', str_replace('\\', '/', dirname(__DIR__)));
define('APP_NAME', 'app');
define('APP', ROOT . '/' . APP_NAME);
define('SYSTEM', ROOT . '/system');

require SYSTEM . '/core/config/config.php';

if (system\core\config\config::globals('dev') != 1) {
    exit();
}

function adminer_object()
{
    class AdminerSoftware extends Adminer
    {
        function login($login, $password)
        {
            return ($login == 'admin' && $password == '');
        }
    }

    return new AdminerSoftware;
}

include __DIR__ . '/adminer.php';
