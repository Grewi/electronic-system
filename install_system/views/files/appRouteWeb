<?php 
use electronic\core\route\route;
use app\controllers\error\error;

$route  = new route();

$route->namespace('app/controllers/index');
$route->get('/')->controller('indexController', 'index');

autoloadWeb($route);

$error = new error();
$error->error404();