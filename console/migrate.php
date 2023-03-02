<?php

namespace system\console;

use system\core\database\database;

class migrate
{
    public function index()
    {
        $db = database::connect();

        //Автоопределение таблицы миграции в БД
        try{
            $start = $db->fetch('SELECT COUNT(*) as count FROM `migrations`', []);
        }catch(\PDOException $e){
            if (!$start) {
                if(file_exists(ROOT . '/app/migrations/0000_00_00.sql')){
                    $startSql = file_get_contents(ROOT . '/app/migrations/0000_00_00.sql');
                    if(!empty($startSql)){
                        $db->query($startSql, []);
                        echo 'Создана стартовая таблица миграции!' . PHP_EOL;
                    }
                }
            }
        }
        



        $allFiles = scandir(ROOT . '/app/migrations');

        //Запуск миграции
            foreach ($allFiles as $i) {
                if ($i == '.' || $i == '..') {
                    continue;
                }
                $i = str_replace('.sql', '', $i);
                $m = $db->fetch('SELECT * FROM migrations WHERE name = "' . $i . '"', []);

                if (empty($m)) {
                    $db->query('INSERT INTO migrations SET name = "' . $i . '", active = "' . date('Y-m-d H:i', time()) . '"', []);
                    if (is_null($m['active'])) {
                        $mSql = file_get_contents(ROOT . '/app/migrations/' . $i . '.sql');
                        if(!empty($mSql)){
                            $db->query($mSql, []);
                            echo $i  . PHP_EOL;                            
                        }
                    }
                }
            }  
    }

    public function createMigration()
    {
        $parametr = ARGV[2];
        $s = preg_replace( "/[^a-zA-Z0-9\s]/", '_', $parametr );
        $fileName = ROOT . '/app/migrations/' . date('Y_m_d_U') . '_' . $s . '.sql'; 
        file_put_contents($fileName, '');
    }
}
