<?php

use system\install_system\system\files;
use system\install_system\system\database;
use system\install_system\adminPanel\adminPanel;
use system\install_system\adminPanel\files as filesAdmin;

$method = $_SERVER['REQUEST_METHOD'];

files::structure($dbType, $dbName, $dbUser, $dbPass, $dbHost, $dbFile, $public);

if ($tableSes) {
    if ($dbType == 'sqlite') {
        database::sessionsSqlite();
    } elseif ($dbType == 'mysql' || $dbType == 'pgsql') {
        database::sessionsMysql();
    }
}


if ($tableUsers) {
    if ($dbType == 'sqlite') {
        database::usersSqlite();
    } elseif ($dbType == 'mysql' || $dbType == 'pgsql') {
        database::usersMysql();
    }
}

if ($tableMigration) {
    if ($dbType == 'sqlite') {
        database::migrationSqlite();
    } elseif ($dbType == 'mysql' || $dbType == 'pgsql') {
        database::migrationMysql();
    }
}

if ($adminPanel) {
    $filesAdmin = new filesAdmin();
    $filesAdmin->structure($dbType, $dbName, $dbUser, $dbPass, $dbHost, $dbFile, $public);
    if ($dbType == 'sqlite') {
        \system\install_system\adminPanel\database::sqlite();
    }else{
        \system\install_system\adminPanel\database::mysql();
    }
    
}

echo 'Установка завершена!' . PHP_EOL;
