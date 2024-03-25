<?php
namespace system\install_system\blog;
use system\core\app\app;

abstract class sql
{
    public function mysql()
    {
        $app = app::app();
        $blogs = $app->install->blogs;
        $blog = $app->install->blog;
        $data = ['blogs' => $blogs, 'blog' => $blog];
        $file = file_get_contents(SYSTEM . '/install_system/blog/sql/mysql.sql');
        foreach ($data as $a => $i) {
            $file = str_replace($a, $i, $file);
        }
        file_put_contents(SYSTEM . '/install_system/blog/sql/mysql2.sql', $file);
        db()->query($file);
    }
}