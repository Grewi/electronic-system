<?php 
declare(strict_types=1);
!INDEX ? exit('exit') : true;

require_once ROOT . '/system/exception.php';

try{
    require_once ROOT . '/system/function.php';
    require_once ROOT . '/system/autoloader.php';
    require_once ROOT . '/system/bootstrap.php';

    if(ENTRANSE == 'web'){
        require_once ROOT . '/app/route/web.php';
    }elseif(ENTRANSE == 'console'){
        require_once ROOT . '/system/console/console.php';
    }
}catch(GlobalException $e){
    exit($e);
}