<?php
define('ENTRANSE', 'install');
define('INDEX', true);
define('ROOT', str_replace('\\', '/', dirname(__DIR__) ));
define('APP_NAME', 'app');
define('APP', ROOT . '/' . APP_NAME);
define('SYSTEM', ROOT . '/system');

if(file_exists(ROOT . '/index.php' )){
    exit('forbiden');
}else{
    require __DIR__ . '/install/install.php';
}

