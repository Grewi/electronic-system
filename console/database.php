<?php 

namespace system\console;
use system\core\config\config;
use system\core\database\database as db;

class database
{

    public function createDump()
    {
        $dbName = config::database('name');
        $dbHost = config::database('host');
        $dbPass = config::database('pass');
        $dbUser = config::database('user');
        $dir = ROOT . '/app/cache/dump/' . date('Y-m-d__U', time()) . '.sql';
        exec('mysqldump --user=' . $dbUser .' --password=' . $dbPass . ' --host=' . $dbHost . ' ' . $dbName . ' > ' . $dir, $output, $status);
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
        $print = exec('mysql  --user=' . $dbUser .' --password=' . $dbPass . ' --host=' . $dbHost . ' ' . $dbName . ' < ' . $dir, $output, $status);
        echo "Процессс завершён \n";
    }

    public function dropTables()
    {
        $db = db::connect();
        $tables = $db->fetchAll('SELECT TABLE_NAME FROM `INFORMATION_SCHEMA`.`TABLES` WHERE TABLE_SCHEMA = "' . config::database('name') . '"', []);
        foreach($tables as $t){
             $db->query("DROP TABLE " . $t['TABLE_NAME'], []);
        } 
    }
}