<?php
// $route->namespace('app/controllers/admin/images')->prefix('admin')->group(ADMIN . '/images', function($route){
//     $route->get('/delete/{image_id}')->controller('imagesController', 'delete');
//     $route->post('/delete/{image_id}')->controller('imagesController', 'deleteAction');
// });

$route->namespace('app/controllers');
$route->get('/images/thumbnail/icon/{name}')->controller('imagesController', 'icon');
$route->get('/images/thumbnail/mini/{name}')->controller('imagesController', 'mini');
$route->get('/images/thumbnail/normal/{name}')->controller('imagesController', 'normal');
$route->get('/images/thumbnail/big/{name}')->controller('imagesController', 'big');