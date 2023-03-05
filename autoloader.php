<?php declare(strict_types=1);
!INDEX ? exit('exit') : true;

function systemAutoLoader(string $className) {
    $className = str_replace('\\', '/', $className);

    //авто переопределение
    $classArr = explode('/', $className);
    $appSystem = ROOT . '/app/' . $className . '.php';
    $originSystem = ROOT . '/' . str_replace('origin/', '', $className) . '.php';
    if($classArr[0] == 'system' && file_exists($appSystem)){
        includeFile($appSystem);
    }elseif($classArr[0] == 'system' && file_exists($originSystem)){
        includeFile(ROOT . '/' . $originSystem . '.php');
    }else{
        includeFile(ROOT . '/' . $className . '.php');
    }
}
spl_autoload_register('systemAutoLoader');