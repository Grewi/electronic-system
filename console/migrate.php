<?php

namespace system\console;

use system\core\database\database;

class migrate
{
    public function index(): void
    {
        $db = database::connect();

        //Автоопределение таблицы миграции в БД
        try {
            $start = $db->fetch('SELECT COUNT(*) as count FROM `migrations`', []);
        } catch (\PDOException $e) {
            if (!$start) {
                if (config('database', 'type') == 'sqlite') {
                    $startSql = '
                    CREATE TABLE `migrations` (
                        `id` INTEGER PRIMARY KEY AUTOINCREMENT,
                        `name` varchar(255) NOT NULL,
                        `active` timestamp NULL DEFAULT NULL
                      );
                      ';
                } else {
                    $startSql = 'SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
                    START TRANSACTION;
                    SET time_zone = "+00:00";
                    
                    CREATE TABLE `migrations` (
                    `id` int(11) NOT NULL,
                    `name` varchar(255) NOT NULL,
                    `active` timestamp NULL DEFAULT NULL
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                    
                    
                    ALTER TABLE `migrations`
                    ADD PRIMARY KEY (`id`);
                    
                    
                    ALTER TABLE `migrations`
                    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
                    COMMIT;';
                }
                $db->query($startSql, []);
                echo 'Создана стартовая таблица миграции!' . PHP_EOL;
            }
        }

        if (!file_exists(MIGRATIONS)) {
            createDir(MIGRATIONS . '/');
            echo 'Создана директория миграций' . PHP_EOL;
        }
        $allFiles = scandir(MIGRATIONS . '/');

        if (!is_iterable($allFiles)) {
            echo 'Миграций нет!' . PHP_EOL;
            return;
        }
        //Запуск миграции
        foreach ($allFiles as $i) {
            if ($i == '.' || $i == '..') {
                continue;
            }
            $i = str_replace('.sql', '', $i);
            $m = $db->fetch('SELECT * FROM migrations WHERE name = "' . $i . '"', []);

            if (empty($m)) {

                try {
                    $mSql = file_get_contents(MIGRATIONS . '/' . $i . '.sql');
                    if (!empty($mSql)) {
                        $db->query('INSERT INTO migrations (`name`, `active`) VALUES ("' . $i . '", "' . date('Y-m-d H:i', time()) . '")', []);
                        $db->query($mSql, []);
                        echo 'Применён ' . $i  . PHP_EOL;
                    } else {
                        echo 'Пустой файл миграции ' . $i  . PHP_EOL;
                    }
                } catch (\PDOException $e) {
                    echo $e->getMessage()   . PHP_EOL;
                }
            } else {
                echo 'Пропущен ' . $i  . PHP_EOL;
            }
        }
    }

    public function createMigration(): void
    {
        $parametr = ARGV[2];
        $s = preg_replace("/[^a-zA-Z0-9\s]/", '_', $parametr);
        $fileName = MIGRATIONS . '/' . date('Y_m_d_U') . '_' . $s . '.sql';
        file_put_contents($fileName, '');
    }
}
