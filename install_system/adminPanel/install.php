<?php
use system\install_system\adminPanel\files;
use system\core\app\app;

$app = app::app();
$app->install->set(['dirInstall' => 'adminPanel']);

$adminPanel = null;

// if ($app->install->tableSes && $app->install->tableUsers && $app->install->tableMigration) {
    while ($adminPanel === null) {
        echo "Установить систему авторизации и  админ-панель? (yes/no): ";
        $i = trim(fgets(STDIN));
        $adminPanel = in_array(mb_strtolower($i), $ok);
    }
// }

if ($adminPanel) {
    $filesAdmin = new files();
    $filesAdmin->structure();
    if ($app->install->dbType == 'sqlite') {
        \system\install_system\adminPanel\database::sqlite();
    }else{
        \system\install_system\adminPanel\database::mysql();
    }
    $filesAdmin->finish();
}