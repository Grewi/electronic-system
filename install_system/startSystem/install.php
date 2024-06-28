<?php
use system\install_system\startSystem\files;
use system\core\app\app;

$app = app::app();
$app->install->set(['dirInstall' => 'startSystem']);


while ($app->install->public === null) {
    echo "Публичная директория (по умолчанию public): ";
    $i = trim(fgets(STDIN));
    $app->install->set(['public' => empty($i) ? 'public' : $i]);
}

$files = new files();
$files->structure();
$files->finish();