<?php

require SYSTEM . '/system.php';
$files =  __DIR__ . '/files/';

$structure = [
    'app' => [
        'cache' => null,
        'configs' => [
            'databace.php' => file_get_contents($files . 'appConfigDatabace'),
            'globals.php' => file_get_contents($files . 'appConfigGlobals'),
            'mail.php' => file_get_contents($files . 'appConfigMail'),
        ],
        'controllers' => [
            'index' => [
                'indexController.php' => file_get_contents($files . 'appControllersIndexIndex'),
            ],
            'error' => [
                'error.php' => file_get_contents($files . 'appControllersErrorError'),
            ],
            'controller.php' => file_get_contents($files . 'appControllersController'),
        ],
        'lang' => [
            'ru' => [
                'global.php' => file_get_contents($files . 'appLangRuGlobal'),
            ],
        ],
        'migrations' => null,
        'models' => null,
        'prefix' => null,
        'route' => [
            'web' => null,
            'console.php' => file_get_contents($files . 'appRouteConsole'),
            'web.php' => file_get_contents($files . 'appRouteWeb'),
        ],
        'views' => [
            'index' => [
                'index.php' => file_get_contents($files . 'appViewIndex'),
            ],
            'layout' => [
                'index.php' => file_get_contents($files . 'appViewLayoutIndex'),
            ],
            'error' => [
                'error404.php' => file_get_contents($files . 'appViewsErrorError404')
            ],

        ],
    ],
    _PUBLIC => [
        '.htaccess' => file_get_contents($files . 'publicHtaccess'),
        'index.php' => file_get_contents($files . 'publicIndex'),
    ],
    'composer' => null,
    'e' => file_get_contents($files . 'e'),
    'index.php' => file_get_contents($files . 'index'),
    '.htaccess' => file_get_contents($files . 'htaccess'),
];


function structure($structure, $path)
{
    foreach ($structure as $a => $i) {
        if (is_array($i)) {
            structure($i, $path . '/' . $a);
        } else {
            createDir(ROOT . $path);
            if(is_null($i)){
                createDir(ROOT . $path . '/' . $a);
            }else{
                file_put_contents(ROOT . $path . '/' . $a, ($i ? $i : ''));
            }
        }
    }
}

structure($structure, '');

redirect('/');
