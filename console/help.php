<?php
namespace system\console;

class help
{
    private $arr = [
        'create/controller' => 'Параметры "v" (+ view) "crud" (create, read, update, delete методы)',
        'create/model ----' => 'Создать модель',
        'migrate----------' => 'Запустить миграции',
        'create/migration-' => 'Создать файл миграции',
        'clean------------' => 'Удаление конфигураций и кеша шаблонов',
        'clean/cache------' => 'Удаление кеша шаблонов',
        'create/dump------' => 'Создание дампа базы',
        'restore/dump-----' => 'Востановление из дампа, путь к файлу /app/cache/dump/file.sql в параметре только file',
        'drop/tables------' => 'Удаление таблиц базы',
        'create/config----' => 'Создание файла конфигурации, параметром принимает имя конфигурации',
        'create/config/ini' => 'Генерирование ini файлов конфигурации',
        'clean/config-----' => 'Удаление всех файлов конфигураций',
        'config-----------' => 'Обновление ini файлов конфигураций',
        'add/complement---' => 'Установка дополнений из отдельных репозиториев, параметром принимает имя репозитория',
        'create/symlink---' => 'Создание символической ссылки "directiry/file directory/linkName"',
        'style------------' => 'Компилирование css файлов по значениям из app/system/sass/sass.php',
        'style/info-------' => 'Список возможных значений для конфигурации sass',
    ];
    public function index()
    {
        foreach($this->arr as $a => $i){
            echo  $a . ' - ' . $i . PHP_EOL;
        }
    }
}