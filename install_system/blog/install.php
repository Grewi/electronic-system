<?php

use system\install_system\blog\files;
use system\install_system\blog\sql\mysql;
use system\install_system\blog\sql\sqlite;
use system\core\app\app;

$app = app::app();
$app->install->set(['dirInstall' => 'blog']);
$blog = null;
$slug = null;

if (!empty(config('database', 'type'))) {
    while ($blog === null) {
        echo "Установить блоги? (yes/no): ";
        $i = trim(fgets(STDIN));
        $blog = in_array(mb_strtolower($i), $ok);
    }
}

if ($blog) {

    while ($slug === null) {
        echo "Введите slug аналогично примеру в единственном и множественном лице разделяя запятыми " . PHP_EOL;
        echo '"blogs, blog": ';
        $i = trim(fgets(STDIN));
        $arr = explode(',', $i);
        if (is_array($arr)) {
            foreach ($arr as &$el) {
                $el = mb_strtolower(trim($el));
            }
            $app->install->set(['blogs'   => $arr[0]]);
            $app->install->set(['blog'    => $arr[1]]);
        }
        $slug = true;
    }

    $files = new files();
    $files->structure();
    $files->finish();

    $sql = new sqlite();
    if ($app->install->dbType == 'sqlite') {
        // $sqlite = new sqlite();
        // $sqlite->install();
    } else {
        $mysql = new mysql();
        $mysql->mysql();
    }
}
