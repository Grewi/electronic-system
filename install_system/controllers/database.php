<?php
namespace system\install_system\controllers;
use system\core\validate\validate;

class database
{
    public static function users()
    {
        $sqlUsers = file_get_contents(SYSTEM . '/install/sql/users.sql');
        db()->query($sqlUsers);
    }

    public static function sessions()
    {
        $sqlSessions = file_get_contents(SYSTEM . '/install/sql/sessions.sql');
        db()->query($sqlSessions);
    }

    public static function migration()
    {
        $sqlSessions = file_get_contents(SYSTEM . '/install/sql/migration.sql');
        db()->query($sqlSessions);       
    }    
}