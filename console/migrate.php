<?php
namespace system\console;
use system\core\database\database;

class migrate
{
    public function index() : void
    {
        $db = database::connect();

        //Автоопределение таблицы миграции в БД
        try{
            $start = $db->fetch('SELECT COUNT(*) as count FROM `migrations`', []);
        }catch(\PDOException $e){
            if (!$start) {
                if(file_exists(APP . '/migrations/0000_00_00.sql')){
                    $startSql = file_get_contents(APP . '/migrations/0000_00_00.sql');
                    if(!empty($startSql)){
                        $db->query($startSql, []);
                        echo 'Создана стартовая таблица миграции!' . PHP_EOL;
                    }
                }
            }
        }
        
        $allFiles = scandir(APP . '/migrations');

        //Запуск миграции
            foreach ($allFiles as $i) {
                if ($i == '.' || $i == '..') {
                    continue;
                }
                $i = str_replace('.sql', '', $i);
                $m = $db->fetch('SELECT * FROM migrations WHERE name = "' . $i . '"', []);

                if (empty($m)) {
                    
                    try {
                        $mSql = file_get_contents(APP . '/migrations/' . $i . '.sql');
                        if(!empty($mSql)){
                            $db->query('INSERT INTO migrations SET name = "' . $i . '", active = "' . date('Y-m-d H:i', time()) . '"', []);
                            $db->query($mSql, []);
                            echo 'Применён ' . $i  . PHP_EOL;                            
                        }else{
                            echo 'Пустой файл миграции ' . $i  . PHP_EOL; 
                        }
                    }catch(\PDOException $e){
                        echo $e->getMessage()   . PHP_EOL;
                    }
                }else{
                    echo 'Пропущен ' . $i  . PHP_EOL; 
                }
            }  
    }

    public function createMigration() : void
    {
        $parametr = ARGV[2];
        $s = preg_replace( "/[^a-zA-Z0-9\s]/", '_', $parametr );
        $fileName = APP . '/migrations/' . date('Y_m_d_U') . '_' . $s . '.sql'; 
        file_put_contents($fileName, '');
    }
}
