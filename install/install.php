<?php

use system\install\files;
use system\install\controllers\form;
use system\install\controllers\database;
use system\install\controllers\migrations;

require SYSTEM . '/system.php';
// require __DIR__ . '/controllers/form.php';

$method = $_SERVER['REQUEST_METHOD'];

files::structure($dbType, $dbName, $dbUser, $dbPass, $dbHost, $public);

if($tableSes){
    database::sessions();
}


if($tableUsers){
    database::users();
}

if($tableMigration){
    database::migration();
}

migrations::start();
redirect('/');
