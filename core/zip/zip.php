<?php 
namespace system\core\zip;

class zip
{
    public static function zip($folder, $zipFile)
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