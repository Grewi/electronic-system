<?php declare(strict_types=1);
!INDEX ? exit('exit') : true;

function systemAutoLoader(string $className) {
    $className = str_replace('\\', '/', $className);
    includeFile(ROOT . '/' . $className . '.php');
}
spl_autoload_register('systemAutoLoader');