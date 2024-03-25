<?php 

$route->namespace('app/controllers/admin/blogs')->prefix('admin')->group(ADMIN . '/blogs', function($route){
    
    $route->get('/categories/create/{parent_id?}')->controller('categoriesController', 'create');
    $route->post('/categories/create/{parent_id?}')->controller('categoriesController', 'createAction');
    $route->get('/categories/edit/{category_id}')->controller('categoriesController', 'update');
    $route->post('/categories/edit/{category_id}')->controller('categoriesController', 'updateAction');
    $route->get('/categories/delete/{category_id}')->controller('categoriesController', 'delete');
    $route->post('/categories/delete/{category_id}')->controller('categoriesController', 'deleteAction');   
    $route->get('/categories/{parent_id?}')->controller('categoriesController', 'index');


    $route->get('/tags')->controller('tagsController', 'index');
    $route->get('/tags/create')->controller('tagsController', 'create');
    $route->post('/tags/create')->controller('tagsController', 'createAction');
    $route->get('/tags/edit/{tag_id}')->controller('tagsController', 'update');
    $route->post('/tags/edit/{tag_id}')->controller('tagsController', 'updateAction');
    $route->get('/tags/delete/{tag_id}')->controller('tagsController', 'delete');
    $route->post('/tags/delete/{tag_id}')->controller('tagsController', 'deleteAction');

    $route->get('/create')->controller('blogsController', 'create');
    $route->post('/create')->controller('blogsController', 'createAction');
    $route->get('/edit/{blog_id}')->controller('blogsController', 'update');
    $route->post('/edit/{blog_id}')->controller('blogsController', 'updateAction');
    $route->get('/delete/{blog_id}')->controller('blogsController', 'delete');
    $route->post('/delete/{blog_id}')->controller('blogsController', 'deleteAction'); 

    $route->post('/sort')->controller('blogsController', 'sortAction');
    $route->post('/category/sort')->controller('categoriesController', 'sortAction');
    $route->post('/tag/sort')->controller('tagsController', 'sortAction');
    
    $route->get('/{category_id?}')->controller('blogsController', 'index');
});

$route->namespace('app/controllers/blogs')->group('/blogs', function($route){
    $route->get('/')->controller('indexController', 'index');
    $route->get('/category/{url}')->controller('indexController', 'category');
    $route->get('/tag/{url}')->controller('indexController', 'tag');
    $route->get('/{url}')->controller('blogsController', 'index');
});

