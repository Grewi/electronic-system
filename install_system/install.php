<?php

use system\install_system\files;
use system\install_system\controllers\database;
use system\install_system\controllers\adminPanel;

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

if($adminPanel){
    adminPanel::index();
    adminPanel::migrate();
}

echo 'Установка завершена!' . PHP_EOL;
