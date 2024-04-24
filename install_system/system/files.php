<?php
namespace system\install_system\system;
use system\core\app\app;


class files extends \system\install_system\files
{
    public function structure()
    {
        $app = app::app();
        $database = [
            'type' => $app->install->dbType,
            'name' => $app->install->dbName,
            'user' => $app->install->dbUser,
            'pass' => $app->install->dbPass,
            'host' => $app->install->dbHost,
            'file' => $app->install->dbFile,
        ];
        $structure = [
            'app' => [
                'cache' => null,
                'configs' => [
                    'database.php' => $this->view('app/config/database.php', $database),
                    'globals.php' => $this->view('app/config/globals.php'),
                    'mail.php' => $this->view('app/config/mail.php'),
                    'errors.php' => $this->view('app/config/errors.php'),
                    'sass.php' => $this->view('app/config/sass.php'),
                ],
                'controllers' => [
                    'index' => [
                        'indexController.php' => $this->view('app/controllers/index/index.php'),
                    ],
                    'error' => [
                        'error.php' => $this->view('app/controllers/error/error.php'),
                    ],
                    'controller.php' => $this->view('app/controllers/controller.php'),
                ],
                'lang' => [
                    'ru' => [
                        'global.php' => $this->view('app/lang/ru/global.php'),
                        'valid.php' => $this->view('app/lang/ru/valid.php'),
                    ],
                ],
                'migrations' => null,
                'models' => null,
                'prefix' => null,
                'filter' => [
                    'bruteforce.php' => $this->view('app/filter/bruteforce.php'),
                ],
                'route' => [
                    'web' => [
                        '02_index.php' => $this->view('app/route/web/02_index.php'),
                    ],
                    'console.php' => $this->view('app/route/console.php'),
                    'web.php' => $this->view('app/route/web.php'),
                    'cron.php' => $this->view('app/route/cron.php'),
                ],
                'views' => [
                    'index' => [
                        'index.php' => $this->view('app/views/index/index.php'),
                    ],
                    'layout' => [
                        'index.php' => $this->view('app/views/layout/index.php'),
                    ],
                    'error' => [
                        'error404.php' => $this->view('app/views/error/error404.php'),
                    ],

                ],
            ],
            $app->install->public => [
                '.htaccess' => $this->view('public/.htaccess'),
                'index.php' => $this->view('public/index.php'),
            ],
            'composer' => null,
            'e' => $this->view('e'),
            'cron' => $this->view('cron'),
            'index.php' => $this->view('index.php'),
            '.htaccess' => $this->view('.htaccess'),
            '.gitignore' => $this->view('.gitignore'),
            'update' => $this->view('update'),
        ];

        $this->structureInstall($structure, '');

        if($app->install->dbFile){
            $sqlite = [
                'sqlite' => [
                    $app->install->dbFile . '.db' => $this->view('sqlite/sqlite'),
                    'adminer.php' => $this->view('sqlite/adminer.php'),
                    'index.php' => $this->view('sqlite/index.php'),
                ],
            ];

            $this->structureInstall($sqlite);
        }
    }
}
