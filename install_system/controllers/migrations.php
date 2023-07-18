<?php 
namespace system\install_system\controllers;
use system\core\config\config;

class migrations
{
    public static function start()
    {
        $dbName = config::database('name');
        $dbHost = config::database('host');
        $dbPass = config::database('pass');
        $dbUser = config::database('user');
        $dumpPath = APP . '/migrations/0000-00-00-start.sql';
        exec('mysqldump --user=' . $dbUser . ' --password=' . $dbPass . ' --host=' . $dbHost . ' ' . $dbName . ' > ' . $dumpPath, $output, $status);
    }
}