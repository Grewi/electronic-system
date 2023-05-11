<?php
use system\install\files;
use system\install\controllers\form;
use system\install\controllers\database;
use system\install\controllers\migrations;

require SYSTEM . '/system.php';
require __DIR__ . '/controllers/form.php';

$method = $_SERVER['REQUEST_METHOD'];

if($method == 'GET'){
    form::index();
}elseif($method == 'POST'){
    files::structure();
    database::sessions();
    database::users();
    migrations::start();
    redirect('/');    
}

