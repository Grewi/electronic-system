<?php
use system\install_system\system\files;
use system\install_system\system\database;
use system\core\app\app;

$app = app::app();
$app->install->set(['dirInstall' => 'system']);

$tableSes = null;
$tableUsers = null;
$tableMigration = null;

while ($app->install->startDb === null) {
    echo "Установить настройки базы данных? (yes/no): ";
    $i = trim(fgets(STDIN));
    if (empty($i)) {
        echo "Значение не установленно!" . PHP_EOL;
        break;
    }
    $app->install->set(['startDb' => $i]);
}

if ($app->install->startDb != null && in_array(mb_strtolower($app->install->startDb), $ok)) {
    while ($app->install->dbType === null) {
        echo "Тип БД (mysql, pgsql, sqlite): ";
        $i = trim(fgets(STDIN));
        if (empty($i)) {
            echo "Значение не установленно!" . PHP_EOL;
            break;
        }
        $app->install->set(['dbType' => $i]);
    }
}

if ($app->install->dbType != null && (mb_strtolower($app->install->dbType) == 'pgsql' || mb_strtolower($app->install->dbType) == 'mysql')) {
    while ($app->install->dbName === null) {
        echo "Имя БД: ";
        $i = trim(fgets(STDIN));
        if (empty($i)) {
            echo "Значение не установленно!" . PHP_EOL;
            break;
        }
        $app->install->set(['dbName' => $i]);
    }

    while ($app->install->dbUser === null) {
        echo "Пользователь БД: ";
        $i = trim(fgets(STDIN));
        if (empty($i)) {
            echo "Значение не установленно!" . PHP_EOL;
            break;
        }
        $app->install->set(['dbUser' => $i]);
        // $dbUser = $i;
    }

    while ($app->install->dbPass === null) {
        echo "Пароль БД: ";
        $i = trim(fgets(STDIN));
        $app->install->set(['dbPass' => empty($i) ? '' : $i]);
    }

    while ($app->install->dbHost === null) {
        echo "Хост БД (по умолчанию localhost): ";
        $i = trim(fgets(STDIN));
        $app->install->set(['dbHost' => empty($dbHost) ? 'localhost' : $i]);
    }
}

if ($app->install->dbType != null && mb_strtolower($app->install->dbType) == 'sqlite') {

    while ($app->install->dbFile === null) {
        echo "Имя файла БД: ";
        $app->install->set(['dbFile' => trim(fgets(STDIN))]);
    }
}

if ($app->install->dbType != null) {
    while ($app->install->TableDb === null) {
        echo "Создать первичные таблицы в БД? (yes/no): ";
        $app->install->set(['TableDb' => trim(fgets(STDIN))]);
    }

    $tableSes = true;
    $tableUsers = true;
    $tableMigration = true;

    if ($app->install->TableDb != null && in_array(mb_strtolower($app->install->TableDb), $ok)) {

        while ($app->install->adminLogin === null) {
            echo "Укажите логин администратора (По умолчанию admin): ";
            $i = trim(fgets(STDIN));
            $app->install->set(['adminLogin' => empty($i) ? 'admin' : $i]);
        }
        while ($app->install->adminPass === null) {
            echo "Укажите пароль администратора (По умолчанию 12345): ";
            $i = trim(fgets(STDIN));
            $app->install->set(['adminPass' => empty($i) ? '12345' : $i]);
        }
        while ($app->install->adminEmail === null) {
            echo "Укажите электропочту администратора (По умолчанию admin@admin.ru): ";
            $i = trim(fgets(STDIN));
            $app->install->set(['adminEmail' => empty($i) ? 'admin@admin.ru' : $i]);
        }        
    }
}

while ($app->install->public === null) {
    echo "Публичная директория (по умолчанию public): ";
    $i = trim(fgets(STDIN));
    $app->install->set(['public' => empty($i) ? 'public' : $i]);
}

$files = new files();
$files->structure();
$files->finish();

if ($tableSes) {
    if ($app->install->dbType == 'sqlite') {
        database::sessionsSqlite();
    } elseif ($app->install->dbType == 'mysql' || $app->install->dbType == 'pgsql') {
        database::sessionsMysql();
    }
}


if ($tableUsers) {
    if ($app->install->dbType == 'sqlite') {
        database::usersSqlite($app->install->adminLogin, $app->install->adminPass, $app->install->adminEmail);
    } elseif ($app->install->dbType == 'mysql' || $app->install->dbType == 'pgsql') {
        database::usersMysql($app->install->adminLogin, $app->install->adminPass, $app->install->adminEmail);
    }
}

if ($tableMigration) {
    if ($app->install->dbType == 'sqlite') {
        database::migrationSqlite();
    } elseif ($app->install->dbType == 'mysql' || $app->install->dbType == 'pgsql') {
        database::migrationMysql();
    }
}