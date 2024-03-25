<?php 
$route->namespace('app/controllers/admin/images')->prefix('admin')->group(ADMIN . '/images', function($route){
    $route->get('/')->controller('imagesController', 'index');
    $route->get('/create')->controller('imagesController', 'create');
    $route->post('/create')->controller('imagesController', 'createAction');
    $route->get('/edit/{param_id}')->controller('imagesController', 'update');
    $route->post('/edit/{param_id}')->controller('imagesController', 'updateAction');
    $route->get('/delete/{param_id}')->controller('imagesController', 'delete');
    $route->post('/delete/{param_id}')->controller('imagesController', 'deleteAction');
});