<?php 
declare(strict_types=1);
!INDEX ? exit('exit') : true;

require_once SYSTEM . '/exception.php';

try{
    require_once SYSTEM . '/function.php';
    require_once SYSTEM . '/autoloader.php';
    require_once SYSTEM . '/bootstrap.php';

    $composer = ROOT . '/composer/vendor/autoload.php';
    if(file_exists($composer)){
        require_once $composer;
    }

    if(ENTRANSE == 'web'){
        require_once APP . '/route/web.php';
    }elseif(ENTRANSE == 'console'){
        require_once SYSTEM . '/console/console.php';
    }
}catch(GlobalException $e){
    dd($e);
    exit();
}