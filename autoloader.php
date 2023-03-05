<?php declare(strict_types=1);
!INDEX ? exit('exit') : true;

function systemAutoLoader(string $className) {
    $className = str_replace('\\', '/', $className);

    //авто переопределение
    $classArr = explode('/', $className);
    $appSystem = ROOT . '/app/' . $className . '.php';
    if($classArr[0] == 'system' && file_exists($appSystem)){
        includeFile($appSystem);
    }else{
        includeFile(ROOT . '/' . $className . '.php');
    }
}
spl_autoload_register('systemAutoLoader');