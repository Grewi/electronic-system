<?php

namespace system\console;

use system\core\config\config;
use system\core\database\database as db;
use system\core\zip\zip;

class database
{

    public function createDump()
    {
        $dbName = config::database('name');
        $dbHost = config::database('host');
        $dbPass = config::database('pass');
        $dbUser = config::database('user');
        $dumpPath = ROOT . '/app/cache/dump';
        $dumpSql = $dumpPath . '/' . date('Y-m-d', time());
        $fileName = date('Y-m-d__U', time());
        createDir($dumpSql);
        $fileSql = $dumpSql . '/' . $fileName . '.sql';
        // exec('mysqldump --user=' . $dbUser . ' --password=' . $dbPass . ' --host=' . $dbHost . ' ' . $dbName . ' --set-charset=utf8mb4 > ' . $fileSql, $output, $status);
        exec('mysqldump --user=' . $dbUser . ' --password=' . $dbPass . ' --host=' . $dbHost . ' ' . $dbName . ' --set-charset=utf8mb4 --result-file=' . $fileSql, $output, $status);
        zip::zip($dumpSql, $dumpPath . '/' . $fileName . '.zip');
        $files = scandir($dumpSql);
        if(is_iterable($files)){
            foreach($files as $file){
                if(is_file($dumpSql . '/' . $file)){
                    unlink($dumpSql . '/' . $file);
                }
            }
        }
        rmdir($dumpSql);
        echo "Процессс завершён \n";
    }

    public function restoreDump()
    {
        $parametr = ARGV[2];
        $dbName = config::database('name');
        $dbHost = config::database('host');
        $dbPass = config::database('pass');
        $dbUser = config::database('user');
        $dir = APP . '/cache/dump/' . $parametr;
        $print = exec('mysql  --user=' . $dbUser . ' --password=' . $dbPass . ' --host=' . $dbHost . ' ' . $dbName . ' < ' . $dir, $output, $status);
        echo "Процессс завершён \n";
    }

    public function dropTables()
    {
        $db = db::connect();
        $db->query('SET FOREIGN_KEY_CHECKS = 0;');
        $tables = $db->fetchAll('SELECT TABLE_NAME FROM `INFORMATION_SCHEMA`.`TABLES` WHERE TABLE_SCHEMA = "' . config::database('name') . '"', []);
        foreach ($tables as $t) {
            $db->query("DROP TABLE " . $t->TABLE_NAME, []);
        }
        $db->query('SET FOREIGN_KEY_CHECKS = 1;');
        echo "Процессс завершён \n";
    }

    private function zip($folder, $zipFile)
    {
        // Получаем реальный путь к нашей папке
        $rootPath = realpath($folder);

        // Инициализация объекта архива
        $zip = new \ZipArchive();
        $zip->open($zipFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        // Создание рекурсивного итератора каталогов

        /** @var SplFileInfo[] $files */

        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($rootPath), \RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $name => $file) {
            // Пропустите каталоги (они будут добавлены автоматически)
            if (!$file->isDir()) {
                // Получение реального и относительного пути для текущего файла
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($rootPath) + 1);
                // Добавить текущий файл в архив
                $zip->addFile($filePath, $relativePath);
            }
        }

        // Zip-архив будет создан только после закрытия объекта
        $zip->close();
    }
}
