<?php

use system\install\files;
use system\install\controllers\database;

require SYSTEM . '/system.php';

$method = $_SERVER['REQUEST_METHOD'];

files::structure($dbType, $dbName, $dbUser, $dbPass, $dbHost, $dbFile, $public);

if($tableSes){
    database::sessions();
}


if($tableUsers){
    database::users();
}

if($tableMigration){
    database::migration();
}

echo 'Установка завершена!' . PHP_EOL;
