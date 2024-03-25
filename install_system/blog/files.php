<?php
namespace system\install_system\blog;
use system\core\app\app;

class files extends \system\install_system\files
{
    public function structure()
    {
        $app = app::app();
        $blogs = $app->install->blogs;
        $blog = $app->install->blog;
        $data = ['blogs' => $blogs, 'blog' => $blog];
        $structure = [
            'app' => [
                'controllers' => [
                    'admin' => [
                        $blogs => [
                            $blogs .'Controller.php' => $this->view('app/controllers/admin/blogs/blogsController.php', $data),
                            'categoriesController.php' => $this->view('app/controllers/admin/blogs/categoriesController.php', $data),
                            'tagsController.php' => $this->view('app/controllers/admin/blogs/tagsController.php', $data),
                        ],
                    ],
                    $blogs => [
                         $blogs . 'Controller.php' => $this->view('app/controllers/blogs/blogsController.php', $data),
                        'indexController.php' => $this->view('app/controllers/blogs/indexController.php', $data),
                    ],
                ],
                'lang' => [
                    'ru' => [
                        $blogs . '.php' => $this->view('app/lang/ru/blogs.php', $data),
                    ],
                ],
                'models' => [
                    $blog .'_category.php' => $this->view('app/models/blog_category.php', $data),
                    $blogs .'.php' => $this->view('app/models/blogs.php', $data),
                    $blogs .'_categories.php' => $this->view('app/models/blogs_categories.php', $data),
                    $blogs .'_tags.php' => $this->view('app/models/blogs_tags.php', $data),
                    $blog .'_tag.php' => $this->view('app/models/blog_tag.php', $data),
                ],
                'route' => [
                    'web' => [
                        '05_' . $blogs .'.php' => $this->view('app/route/web/05_blogs.php', $data),
                    ],
                ],
                'views' =>[
                    'admin' => [
                        'admin' => [
                            'menu' => [
                                'left' => [
                                    '400_' . $blogs .'.php' => $this->view('app/views/admin/admin/menu/left/400_blogs.php', $data),
                                ],
                            ],
                        ],
                        $blogs => [
                            $blogs => [
                                'create.php' => $this->view('app/views/admin/blogs/blogs/create.php', $data),
                                'delete.php' => $this->view('app/views/admin/blogs/blogs/delete.php', $data),
                                'index.php' => $this->view('app/views/admin/blogs/blogs/index.php', $data),
                                'update.php' => $this->view('app/views/admin/blogs/blogs/update.php', $data),
                            ],
                            'categories' => [
                                'create.php' => $this->view('app/views/admin/blogs/categories/create.php', $data),
                                'delete.php' => $this->view('app/views/admin/blogs/categories/delete.php', $data),
                                'index.php' => $this->view('app/views/admin/blogs/categories/index.php', $data),
                                'update.php' => $this->view('app/views/admin/blogs/categories/update.php', $data),
                            ],
                            'tags' => [
                                'create.php' => $this->view('app/views/admin/blogs/tags/create.php', $data),
                                'delete.php' => $this->view('app/views/admin/blogs/tags/delete.php', $data),
                                'index.php' => $this->view('app/views/admin/blogs/tags/index.php', $data),
                                'update.php' => $this->view('app/views/admin/blogs/tags/update.php', $data),
                            ],
                        ],
                    ],
                    $blogs => [
                        $blogs => [
                            'index.php' => $this->view('app/views/blogs/blogs/index.php', $data),
                        ],
                        'index' => [
                            'category.php' => $this->view('app/views/blogs/index/category.php', $data),
                            'index.php' => $this->view('app/views/blogs/index/index.php', $data),
                            'tag.php' => $this->view('app/views/blogs/index/tag.php', $data),
                        ],
                        'card.php' => $this->view('app/views/blogs/card.php', $data),
                        'cardLine.php' => $this->view('app/views/blogs/cardLine.php', $data),
                    ],
                ],
            ],

        ];
        $this->structureInstall($structure);
    }

    protected function view(string $file, array $data = [])
    {
        $app = app::app();
        $content = file_get_contents(SYSTEM . '/install_system/' . $app->install->dirInstall . '/views/' . $file);

        foreach ($data as $a => $i) {
            $content = str_replace($a, $i, $content);
        }
        return $content;
    }
}