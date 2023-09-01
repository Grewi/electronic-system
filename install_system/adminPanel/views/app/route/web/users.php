<?php
$route->filter('auth');
$route->namespace('app/controllers/users');
$route->get('/register')->prefix('goust')->controller('registerController', 'index');
$route->post('/register')->prefix('goust')->controller('registerController', 'register');

$route->get('/auth')->prefix('user')->controller('authController', 'indexUser');
$route->get('/user')->prefix('user')->controller('authController', 'indexUser');
$route->get('/auth')->prefix('goust')->controller('authController', 'indexGoust');