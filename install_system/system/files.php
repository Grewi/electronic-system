<?php

namespace system\install_system\system;

use system\core\validate\validate;

class files
{
    public static function structure($type, $name, $user, $pass, $host, $file, $public)
    {
        $database = [
            'type' => $type,
            'name' => $name,
            'user' => $user,
            'pass' => $pass,
            'host' => $host,
            'file' => $file,
        ];
        $structure = [
            'app' => [
                'cache' => null,
                'configs' => [
                    'database.php' => self::view('app/config/database.php', $database),
                    'globals.php' => self::view('app/config/globals.php'),
                    'mail.php' => self::view('app/config/mail.php'),
                ],
                'controllers' => [
                    'index' => [
                        'indexController.php' => self::view('app/controllers/index/index.php'),
                    ],
                    'error' => [
                        'error.php' => self::view('app/controllers/error/error.php'),
                    ],
                    'controller.php' => self::view('app/controllers/controller.php'),
                ],
                'lang' => [
                    'ru' => [
                        'global.php' => self::view('app/lang/ru/global.php'),
                        'valid.php' => self::view('app/lang/ru/valid.php'),
                    ],
                ],
                'migrations' => null,
                'models' => null,
                'prefix' => null,
                'filter' => null,
                'route' => [
                    'web' => null,
                    'console.php' => self::view('app/route/console.php'),
                    'web.php' => self::view('app/route/web.php'),
                ],
                'views' => [
                    'index' => [
                        'index.php' => self::view('app/views/index/index.php'),
                    ],
                    'layout' => [
                        'index.php' => self::view('app/views/layout/index.php'),
                    ],
                    'error' => [
                        'error404.php' => self::view('app/views/error/error404.php'),
                    ],

                ],
            ],
            $public => [
                '.htaccess' => self::view('public/.htaccess'),
                'index.php' => self::view('public/index.php'),
            ],
            'composer' => null,
            'e' => self::view('e'),
            'index.php' => self::view('index.php'),
            '.htaccess' => self::view('.htaccess'),
            'update' => self::view('update'),
        ];

        self::structureInstall($structure, '');

        if($file){
            $sqlite = [
                'sqlite' => [
                    $file . '.db' => self::view('sqlite/sqlite'),
                    'adminer.php' => self::view('sqlite/adminer.php'),
                    'index.php' => self::view('sqlite/index.php'),
                ],
            ];

            self::structureInstall($sqlite, '');
        }
    }

    private static function structureInstall($structure, $path)
    {
        foreach ($structure as $a => $i) {
            if (is_array($i)) {
                self::structureInstall($i, $path . '/' . $a);
            } else {
                createDir(ROOT . $path);
                if (is_null($i)) {
                    createDir(ROOT . $path . '/' . $a);
                } else {
                    file_put_contents(ROOT . $path . '/' . $a, ($i ? $i : ''));
                }
            }
        }
    }

    private static function view(string $file, array $data = [])
    {
        $content = file_get_contents(SYSTEM . '/install_system/system//views/' . $file);

        preg_match_all('/\{\{\s*\$(.*?)\s*\}\}(else\{\{(.*?)}\})?/si', $content, $matches);
        foreach ($matches[1] as $a => $i) {
            $content = str_replace($matches[0][$a], isset($data[$i]) ? $data[$i] : '', $content);
        }
        return $content;
    }
}
