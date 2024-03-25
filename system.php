<?php 
declare(strict_types=1);
!INDEX ? exit('exit') : true;

if(session_status() != PHP_SESSION_ACTIVE){
    session_start();
}

if(!defined('ROOT')){
    define('ROOT', str_replace('\\', '/', dirname(__DIR__)));
}

if(!defined('APP_NAME')){
    define('APP_NAME', 'app');
}

if(!defined('APP')){
    define('APP', ROOT . '/' . APP_NAME);
}

if(!defined('SYSTEM')){
    define('SYSTEM', ROOT . '/system');
}

if(!defined('MIGRATIONS')){
    define('MIGRATIONS', APP . '/migrations');
}

if(!defined('MODELS')){
    define('MODELS', APP . '/models');
}

require_once SYSTEM . '/exception.php';

try{
    require_once SYSTEM . '/function.php';
    require_once SYSTEM . '/autoloader.php';
    require_once SYSTEM . '/bootstrap.php';

    $composer = ROOT . '/composer/vendor/autoload.php';
    if(file_exists($composer)){
        require_once $composer;
    }

    require_once SYSTEM . '/errors.php';

    if(ENTRANSE == 'web'){
        require_once APP . '/route/web.php';
    }elseif(ENTRANSE == 'console'){
        require_once SYSTEM . '/console/console.php';
    }elseif(ENTRANSE == 'cron'){
        require_once APP . '/route/cron.php';
    }
}catch(GlobalException $e){
    exit($e);
}