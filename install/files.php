<?php

namespace system\install;

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
                    'database.php' => self::view('appConfigDatabace', $database),
                    'globals.php' => self::view('appConfigGlobals'),
                    'mail.php' => self::view('appConfigMail'),
                ],
                'controllers' => [
                    'index' => [
                        'indexController.php' => self::view('appControllersIndexIndex'),
                    ],
                    'error' => [
                        'error.php' => self::view('appControllersErrorError'),
                    ],
                    'controller.php' => self::view('appControllersController'),
                ],
                'lang' => [
                    'ru' => [
                        'global.php' => self::view('appLangRuGlobal'),
                    ],
                ],
                'migrations' => null,
                'models' => null,
                'prefix' => null,
                'filter' => null,
                'route' => [
                    'web' => null,
                    'console.php' => self::view('appRouteConsole'),
                    'web.php' => self::view('appRouteWeb'),
                ],
                'views' => [
                    'index' => [
                        'index.php' => self::view('appViewIndex'),
                    ],
                    'layout' => [
                        'index.php' => self::view('appViewLayoutIndex'),
                    ],
                    'error' => [
                        'error404.php' => self::view('appViewsErrorError404'),
                    ],

                ],
            ],
            $public => [
                '.htaccess' => self::view('publicHtaccess'),
                'index.php' => self::view('publicIndex'),
            ],
            'composer' => null,
            'e' => self::view('e'),
            'index.php' => self::view('index'),
            '.htaccess' => self::view('htaccess'),
        ];

        self::structureInstall($structure, '');

        if($file){
            $sqlite = [
                'sqlite' => [
                    $file . '.db' => self::view('sqlite'),
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
        $content = file_get_contents(__DIR__ . '/views/files/' . $file);

        preg_match_all('/\{\{\s*\$(.*?)\s*\}\}(else\{\{(.*?)}\})?/si', $content, $matches);
        foreach ($matches[1] as $a => $i) {
            $content = str_replace($matches[0][$a], isset($data[$i]) ? $data[$i] : '', $content);
        }
        return $content;
    }
}
