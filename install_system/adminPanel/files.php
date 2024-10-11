<?php
namespace system\install_system\adminPanel;
use system\core\app\app;

class files extends \system\install_system\files
{
    public function structure()
    {
        $app = app::app();
        $structure = [
            'app' => [
                'controllers' => [
                    'admin' => [
                        'adminController.php' => $this->view('app/controllers/admin/adminController.php'),
                        'controller.php' => $this->view('app/controllers/admin/controller.php'),
                        'pageGeneratorController.php' => $this->view('app/controllers/admin/pageGeneratorController.php'),
                        'userRoleController.php' => $this->view('app/controllers/admin/userRoleController.php'),
                        'usersController.php' => $this->view('app/controllers/admin/usersController.php'),
                        'settings' => [
                            'settingsController.php' => $this->view('app/controllers/admin/settings/settingsController.php'),
                        ],
                        'images' => [
                            'imagesController.php' => $this->view('app/controllers/admin/images/imagesController.php'),
                        ],
                    ],
                    'generatorPage' => [
                        'pageController.php' => $this->view('app/controllers/generatorPage/pageController.php'),
                    ],
                    'users' => [
                        'authController.php' => $this->view('app/controllers/users/authController.php'),
                        'registerController.php' => $this->view('app/controllers/users/registerController.php'),
                        'usersController.php' => $this->view('app/controllers/users/usersController.php'),
                    ],
                    'imagesController.php' => $this->view('app/controllers/imagesController.php'),
                ],
                'lang' => [
                    'ru' => [
                        'admin.php' => $this->view('app/lang/ru/admin.php'),
                        'register.php' => $this->view('app/lang/ru/register.php'),
                    ],
                ],
                'filter' => [
                    'auth.php' => $this->view('app/filter/auth.php'),
                ],
                // 'migrations' => [
                //     'installAdmin.sql' => $this->view('app/migrations/installAdmin.sql'),
                //     'installAdmin.sql' => $this->view('app/migrations/userRoleData.sql'),
                // ],

                'models' => [
                    'data_page_generator.php' => $this->view('app/models/data_page_generator.php'),
                    'page_generator.php' => $this->view('app/models/page_generator.php'),
                    'user_role.php' => $this->view('app/models/user_role.php'),
                    'users.php' => $this->view('app/models/users.php'),
                    'settings_category.php' => $this->view('app/models/settings_category.php'),
                    'settings_type.php' => $this->view('app/models/settings_type.php'),
                    'settings.php' => $this->view('app/models/settings.php'),
                    'image_size.php' => $this->view('app/models/image_size.php'),
                    'images.php' => $this->view('app/models/images.php'),
                ],
                'prefix' => [
                    'admin.php' => $this->view('app/prefix/admin.php'),
                    'goust.php' => $this->view('app/prefix/goust.php'),
                    'user.php' => $this->view('app/prefix/user.php'),
                ],
                'route' => [
                    'web' => [
                        '01_authFilter.php' => $this->view('app/route/web/01_authFilter.php'),
                        '10_admin.php' => $this->view('app/route/web/10_admin.php'),
                        '20_users.php' => $this->view('app/route/web/20_users.php'),
                        '99_generatorPage.php' => $this->view('app/route/web/99_generatorPage.php'),
                        '06_admin_images_images.php' => $this->view('app/route/web/06_admin_images_images.php'),
                        '07_images.php' => $this->view('app/route/web/07_images.php'),
                    ],
                ],
                'views' => [
                    'admin' => [
                        'admin' => [
                            'index.php' => $this->view('app/views/admin/admin/index.php'),
                            'menu' => [
                                'left' => [
                                    '100_users.php' => $this->view('app/views/admin/admin/menu/left/100_users.php'),
                                    '200_pg.php' => $this->view('app/views/admin/admin/menu/left/200_pg.php'),
                                    '900_settings.php' => $this->view('app/views/admin/admin/menu/left/900_settings.php'),
                                    '500_images.php' => $this->view('app/views/admin/admin/menu/left/500_images.php'),
                                ],
                            ],
                        ],
                        'include' => [
                            'leftMenu.php' => $this->view('app/views/admin/include/leftMenu.php'),
                            'topInfoPanel.php' => $this->view('app/views/admin/include/topInfoPanel.php'),
                            'topSearchPanel.php' => $this->view('app/views/admin/include/topSearchPanel.php'),
                            'topUserPanel.php' => $this->view('app/views/admin/include/topUserPanel.php'),
                        ],
                        'pageGenerator' => [
                            'data' => [
                                'index.php' => $this->view('app/views/admin/pageGenerator/data/index.php'),
                                'create.php' => $this->view('app/views/admin/pageGenerator/data/create.php'),
                                'delete.php' => $this->view('app/views/admin/pageGenerator/data/delete.php'),
                                'update.php' => $this->view('app/views/admin/pageGenerator/data/update.php'),
                            ],
                            'index.php' => $this->view('app/views/admin/pageGenerator/index.php'),
                            'create.php' => $this->view('app/views/admin/pageGenerator/create.php'),
                            'delete.php' => $this->view('app/views/admin/pageGenerator/delete.php'),
                            'update.php' => $this->view('app/views/admin/pageGenerator/update.php'),
                        ],
                        'settings' => [
                            'categorySettings' => [
                                'create.php' => $this->view('app/views/admin/settings/categorySettings/create.php'),
                                'delete.php' => $this->view('app/views/admin/settings/categorySettings/delete.php'),
                                'update.php' => $this->view('app/views/admin/settings/categorySettings/update.php'),
                            ],
                            'managerSettings' => [
                                'create.php' => $this->view('app/views/admin/settings/managerSettings/create.php'),
                                'delete.php' => $this->view('app/views/admin/settings/managerSettings/delete.php'),
                                'update.php' => $this->view('app/views/admin/settings/managerSettings/update.php'),
                            ],
                            'settings' => [
                                'index.php' => $this->view('app/views/admin/settings/settings/index.php'),
                                'settings.php' => $this->view('app/views/admin/settings/settings/settings.php'),
                            ],
                        ],
                        'images' => [
                            'images' => [
                                'create.php' => $this->view('app/views/admin/images/images/create.php'),
                                'delete.php' => $this->view('app/views/admin/images/images/delete.php'),
                                'update.php' => $this->view('app/views/admin/images/images/update.php'),
                                'index.php' => $this->view('app/views/admin/images/images/index.php'),
                            ],
                        ],
                        'userRole' => [
                            'index.php' => $this->view('app/views/admin/userRole/index.php'),
                            'create.php' => $this->view('app/views/admin/userRole/create.php'),
                            'delete.php' => $this->view('app/views/admin/userRole/delete.php'),
                            'update.php' => $this->view('app/views/admin/userRole/update.php'),
                        ],
                        'users' => [
                            'index.php' => $this->view('app/views/admin/users/index.php'),
                            'create.php' => $this->view('app/views/admin/users/create.php'),
                            'delete.php' => $this->view('app/views/admin/users/delete.php'),
                            'update.php' => $this->view('app/views/admin/users/update.php'),
                        ],
                    ],
                    'generatorPage' => [
                        'page' => [
                            'index.php' => $this->view('app/views/generatorPage/page/index.php'),
                        ],
                        'contacts.php' => $this->view('app/views/generatorPage/contacts.php'),
                        'test.php' => $this->view('app/views/generatorPage/test.php'),
                    ],
                    'include' => [
                        'bc.php' => $this->view('app/views/include/bc.php'),
                        'pagination.php' => $this->view('app/views/include/pagination.php'),
                    ],
                    'layout' => [
                        'admin.php' => $this->view('app/views/layout/admin.php'),
                    ],
                    'users' => [
                        'auth' => [
                            'indexGoust.php' => $this->view('app/views/users/auth/indexGoust.php'),
                            'indexUser.php' => $this->view('app/views/users/auth/indexUser.php'),
                            'create.php' => $this->view('app/views/users/auth/create.php'),
                            'delete.php' => $this->view('app/views/users/auth/delete.php'),
                            'update.php' => $this->view('app/views/users/auth/update.php'),
                        ],
                        'register' => [
                            'register.php' => $this->view('app/views/users/register/register.php'),
                        ],
                        'users' => [
                            'index.php' => $this->view('app/views/users/users/index.php'),
                            'create.php' => $this->view('app/views/users/users/create.php'),
                            'delete.php' => $this->view('app/views/users/users/delete.php'),
                            'update.php' => $this->view('app/views/users/users/update.php'),
                        ],
                    ],
                ],
            ],
            'composer' => [
                'composer.json' => $this->view('composer/composer.json'),
            ],
        ];

        $this->structureInstall($structure);
        $this->copyDir(SYSTEM . '/install_system/adminPanel/views/public/adm', ROOT . '/' . $app->install->public . '/adm');
    }
}
