<?php
namespace system\install_system\system;
use system\core\validate\validate;

class database
{
    public static function usersMysql()
    {
        $sqlUsers = file_get_contents(SYSTEM . '/install_system/system/sql/mysql/users.sql');
        db()->query($sqlUsers);
    }

    public static function sessionsMysql()
    {
        $sqlSessions = file_get_contents(SYSTEM . '/install_system/system/sql/mysql/sessions.sql');
        db()->query($sqlSessions);
    }

    public static function migrationMysql()
    {
        $sqlSessions = file_get_contents(SYSTEM . '/install_system/system/sql/mysql/migration.sql');
        db()->query($sqlSessions);       
    } 
    
    public static function usersSqlite()
    {
        $sqlUsers = file_get_contents(SYSTEM . '/install_system/system/sql/sqlite/users.sql');
        db()->query($sqlUsers);
        $sqlUsersAdmin = file_get_contents(SYSTEM . '/install_system/system/sql/sqlite/user_admin.sql');
        db()->query($sqlUsersAdmin);        
    }

    public static function sessionsSqlite()
    {
        $sqlSessions = file_get_contents(SYSTEM . '/install_system/system/sql/sqlite/sessions.sql');
        db()->query($sqlSessions);
    }

    public static function migrationSqlite()
    {
        $sqlSessions = file_get_contents(SYSTEM . '/install_system/system/sql/sqlite/migration.sql');
        db()->query($sqlSessions);       
    }  
}