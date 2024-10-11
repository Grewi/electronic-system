<?php

$route->namespace('app/controllers/admin')->prefix('admin')->group(ADMIN, function ($route) {
    
    $route->get('/')->controller('adminController', 'index');
});

$route->namespace('app/controllers/admin')->prefix('admin')->group('admin/users', function ($route) {
    $route->get('/')->controller('usersController', 'index');
});

$route->namespace('app/controllers/admin')->prefix('admin')->group('admin/user', function ($route) {
    $route->get('/create')->controller('usersController', 'create');
    $route->post('/create')->controller('usersController', 'createAction');
    $route->get('/edit/{user_id}')->controller('usersController', 'update');
    $route->post('/edit/{user_id}')->controller('usersController', 'updateAction');
    $route->get('/delete/{user_id}')->controller('usersController', 'delete');
    $route->post('/delete/{user_id}')->controller('usersController', 'deleteAction');
});

$route->namespace('app\controllers\admin')->prefix('admin')->group('admin/roles', function($route){
    $route->get('/')->controller('userRoleController', 'index');
});

$route->namespace('app/controllers/admin/settings')->prefix('admin')->group('admin/settings/manager', function($route){
    $route->get('/create/{category_id?}')->controller('settingsController', 'create');
    $route->post('/create/{category_id?}')->controller('settingsController', 'createAction');
    $route->get('/edit/{setting_id}')->controller('settingsController', 'update');
    $route->post('/edit/{setting_id}')->controller('settingsController', 'updateAction');
    $route->get('/delete/{setting_id}')->controller('settingsController', 'delete');
    $route->post('/delete/{setting_id}')->controller('settingsController', 'deleteAction');
});

$route->namespace('app/controllers/admin/settings')->prefix('admin')->group('admin/settings/category', function($route){
    $route->get('/create')->controller('settingsController', 'createCategory');
    $route->post('/create')->controller('settingsController', 'createCategoryAction');
    $route->get('/edit/{setting_id}')->controller('settingsController', 'updateCategory');
    $route->post('/edit/{setting_id}')->controller('settingsController', 'updateCategoryAction');
    $route->get('/delete/{setting_id}')->controller('settingsController', 'deleteCategory');
    $route->post('/delete/{setting_id}')->controller('settingsController', 'deleteCategoryAction');
});

$route->namespace('app/controllers/admin/settings')->prefix('admin')->group('admin/settings', function($route){
    $route->get('/')->controller('settingsController', 'index');
    $route->get('/{caegory_id}')->controller('settingsController', 'settings');
    $route->post('/{caegory_id}')->controller('settingsController', 'save');
});