<?php

namespace system\install_system\adminPanel;

use system\console\migrate;

class files
{
    private $countFiles = 0;
    public function structure($type, $name, $user, $pass, $host, $file, $public)
    {
        $structure = [
            'app' => [
                'controllers' => [
                    'admin' => [
                        'adminController.php' => self::view('app/controllers/admin/adminController.php'),
                        'controller.php' => self::view('app/controllers/admin/controller.php'),
                        'pageGeneratorController.php' => self::view('app/controllers/admin/pageGeneratorController.php'),
                        'userRoleController.php' => self::view('app/controllers/admin/userRoleController.php'),
                        'usersController.php' => self::view('app/controllers/admin/usersController.php'),
                        'settings' => [
                            'settingsController.php' => self::view('app/controllers/admin/settings/settingsController.php'),
                        ],
                    ],
                    'generatorPage' => [
                        'pageController.php' => self::view('app/controllers/generatorPage/pageController.php'),
                    ],
                    'users' => [
                        'authController.php' => self::view('app/controllers/users/authController.php'),
                        'registerController.php' => self::view('app/controllers/users/registerController.php'),
                        'usersController' => self::view('app/controllers/users/usersController.php'),
                    ],
                ],
                'lang' => [
                    'ru' => [
                        'admin.php' => self::view('app/lang/ru/admin.php'),
                        'register.php' => self::view('app/lang/ru/register.php'),
                    ],
                ],
                'filter' => [
                    'auth.php' => self::view('app/filter/auth.php'),
                ],
                // 'migrations' => [
                //     'installAdmin.sql' => self::view('app/migrations/installAdmin.sql'),
                //     'installAdmin.sql' => self::view('app/migrations/userRoleData.sql'),
                // ],

                'models' => [
                    'data_page_generator.php' => self::view('app/models/data_page_generator.php'),
                    'page_generator.php' => self::view('app/models/page_generator.php'),
                    'user_role.php' => self::view('app/models/user_role.php'),
                    'users.php' => self::view('app/models/users.php'),
                    'settings_category.php' => self::view('app/models/settings_category.php'),
                    'settings_type.php' => self::view('app/models/settings_type.php'),
                    'settings.php' => self::view('app/models/settings.php'),
                ],
                'prefix' => [
                    'admin.php' => self::view('app/prefix/admin.php'),
                    'goust.php' => self::view('app/prefix/goust.php'),
                    'user.php' => self::view('app/prefix/user.php'),
                ],
                'route' => [
                    'web' => [
                        'admin.php' => self::view('app/route/web/admin.php'),
                        'generatorPage.php' => self::view('app/route/web/generatorPage.php'),
                        'users.php' => self::view('app/route/web/users.php'),
                    ],
                ],
                'views' => [
                    'admin' => [
                        'admin' => [
                            'index.php' => self::view('app/views/admin/admin/index.php'),
                            'create.php' => self::view('app/views/admin/admin/create.php'),
                            'delete.php' => self::view('app/views/admin/admin/delete.php'),
                            'update.php' => self::view('app/views/admin/admin/update.php'),
                        ],
                        'include' => [
                            'leftMenu.php' => self::view('app/views/admin/include/leftMenu.php'),
                            'topInfoPanel.php' => self::view('app/views/admin/include/topInfoPanel.php'),
                            'topSearchPanel.php' => self::view('app/views/admin/include/topSearchPanel.php'),
                            'topUserPanel.php' => self::view('app/views/admin/include/topUserPanel.php'),
                        ],
                        'pageGenerator' => [
                            'data' => [
                                'index.php' => self::view('app/views/admin/pageGenerator/data/index.php'),
                                'create.php' => self::view('app/views/admin/pageGenerator/data/create.php'),
                                'delete.php' => self::view('app/views/admin/pageGenerator/data/delete.php'),
                                'update.php' => self::view('app/views/admin/pageGenerator/data/update.php'),
                            ],
                            'index.php' => self::view('app/views/admin/pageGenerator/index.php'),
                            'create.php' => self::view('app/views/admin/pageGenerator/create.php'),
                            'delete.php' => self::view('app/views/admin/pageGenerator/delete.php'),
                            'update.php' => self::view('app/views/admin/pageGenerator/update.php'),
                        ],
                        'settings' => [
                            'categorySettings' => [
                                'create.php' => self::view('app/views/admin/settings/categorySettings/create.php'),
                                'delete.php' => self::view('app/views/admin/settings/categorySettings/delete.php'),
                                'update.php' => self::view('app/views/admin/settings/categorySettings/update.php'),
                            ],
                            'managerSettings' => [
                                'create.php' => self::view('app/views/admin/settings/managerSettings/create.php'),
                                'delete.php' => self::view('app/views/admin/settings/managerSettings/delete.php'),
                                'update.php' => self::view('app/views/admin/settings/managerSettings/update.php'),                                
                            ],
                            'settings' => [
                                'index.php' => self::view('app/views/admin/settings/settings/index.php'), 
                                'settings.php' => self::view('app/views/admin/settings/settings/settings.php'), 
                            ],
                        ],
                        'userRole' => [
                            'index.php' => self::view('app/views/admin/userRole/index.php'),
                            'create.php' => self::view('app/views/admin/userRole/create.php'),
                            'delete.php' => self::view('app/views/admin/userRole/delete.php'),
                            'update.php' => self::view('app/views/admin/userRole/update.php'),
                        ],
                        'users' => [
                            'index.php' => self::view('app/views/admin/users/index.php'),
                            'create.php' => self::view('app/views/admin/users/create.php'),
                            'delete.php' => self::view('app/views/admin/users/delete.php'),
                            'update.php' => self::view('app/views/admin/users/update.php'),
                        ],
                    ],
                    'generatorPage' => [
                        'page' => [
                            'index.php' => self::view('app/views/generatorPage/page/index.php'),
                        ],
                        'contacts.php' => self::view('app/views/generatorPage/contacts.php'),
                        'test.php' => self::view('app/views/generatorPage/test.php'),
                    ],
                    'include' => [
                        'bc.php' => self::view('app/views/include/bc.php'),
                        'pagination.php' => self::view('app/views/include/pagination.php'),
                    ],
                    'layout' => [
                        'admin.php' => self::view('app/views/layout/admin.php'),
                    ],
                    'users' => [
                        'auth' => [
                            'indexGoust.php' => self::view('app/views/users/auth/indexGoust.php'),
                            'indexUser.php' => self::view('app/views/users/auth/indexUser.php'),
                            'create.php' => self::view('app/views/users/auth/create.php'),
                            'delete.php' => self::view('app/views/users/auth/delete.php'),
                            'update.php' => self::view('app/views/users/auth/update.php'),
                        ],
                        'register' => [
                            'register.php' => self::view('app/views/users/register/register.php'),
                        ],
                        'users' => [
                            'index.php' => self::view('app/views/users/users/index.php'),
                            'create.php' => self::view('app/views/users/users/create.php'),
                            'delete.php' => self::view('app/views/users/users/delete.php'),
                            'update.php' => self::view('app/views/users/users/update.php'),                            
                        ],
                    ],
                ],
            ],
        ];

        self::structureInstall($structure, '');

        $this->copyDir(SYSTEM . '/install_system/adminPanel/views/' . $public . '/admin-style', ROOT . '/' . $public . '/admin-style');
        echo 'Копирование завершено                                                                                                                                           ' . PHP_EOL;
    }

    private function structureInstall($structure, $path)
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
        $content = file_get_contents(SYSTEM . '/install_system/adminPanel/views/' . $file);

        preg_match_all('/\{\{\s*\$(.*?)\s*\}\}(else\{\{(.*?)}\})?/si', $content, $matches);
        foreach ($matches[1] as $a => $i) {
            $content = str_replace($matches[0][$a], isset($data[$i]) ? $data[$i] : '', $content);
        }
        return $content;
    }

    private function copyDir($from, $to, $rewrite = true)
    {

        if (is_dir($from)) {
            @mkdir($to);
            $d = dir($from);
            while (false !== ($entry = $d->read())) {
                if ($entry == "." || $entry == "..")
                    continue;
                // echo " Копирование:  $to/$entry             \r";    
                $this->copyDir($from . '/' . $entry, $to . '/' . $entry, $rewrite);
            }
            $d->close();
        } else {
            if (!file_exists($to) || $rewrite) {
                ++$this->countFiles;
                echo " Копирование:  $this->countFiles файлов             \r";
                copy($from, $to);
            }
        }
    }
}
