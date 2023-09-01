<?php

$route->namespace('app/controllers/admin')->prefix('admin')->group('admin/pg', function($route){
    
    $route->get('/')->controller('pageGeneratorController', 'index');
    $route->get('/data/create/{pg_id}')->controller('pageGeneratorController', 'pgAddData');
    $route->post('/data/create/{pg_id}')->controller('pageGeneratorController', 'pgListSave');
    $route->get('/data/edit/{data_id}')->controller('pageGeneratorController', 'pgDataEdit');
    $route->post('/data/edit/{data_id}')->controller('pageGeneratorController', 'pgDataEditSave');
    $route->get('/data/delete/{data_id}')->controller('pageGeneratorController', 'pgDataDelete');
    $route->post('/data/delete/{data_id}')->controller('pageGeneratorController', 'pgDataDeleteAction');    
    $route->get('/data/{pg_id}')->controller('pageGeneratorController', 'pgList');
    // $route->post('/data/{pg_id}')->controller('pageGeneratorController', 'pgListSave');
    $route->get('/create')->controller('pageGeneratorController', 'create');
    $route->post('/create')->controller('pageGeneratorController', 'createAction');
    $route->get('/edit/{page_id}')->controller('pageGeneratorController', 'update');
    $route->post('/edit/{page_id}')->controller('pageGeneratorController', 'updateAction');
    $route->get('/delete/{page_id}')->controller('pageGeneratorController', 'delete');
    $route->post('/delete/{page_id}')->controller('pageGeneratorController', 'deleteAction');
});

$route->namespace('app/controllers/generatorPage');
$route->get()->controller('pageController', 'index');