<?php
namespace system\install_system\system;
use system\core\validate\validate;

class database
{
    public static function usersMysql($adminLogin, $adminPass, $adminEmail)
    {
        $sqlUsers = file_get_contents(SYSTEM . '/install_system/system/sql/mysql/users.sql');
        $sqlUsers = str_replace('{login}', $adminLogin, $sqlUsers);
        $sqlUsers = str_replace('{email}', $adminEmail, $sqlUsers);
        $sqlUsers = str_replace('{pass}', password_hash($adminPass, PASSWORD_DEFAULT), $sqlUsers);
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
    
    public static function usersSqlite($adminLogin, $adminPass, $adminEmail)
    {
        $sqlUsers = file_get_contents(SYSTEM . '/install_system/system/sql/sqlite/users.sql');
        db()->query($sqlUsers);
        $sqlUsersAdmin = file_get_contents(SYSTEM . '/install_system/system/sql/sqlite/user_admin.sql');
        $sqlUsersAdmin = str_replace('{login}', $adminLogin, $sqlUsersAdmin);
        $sqlUsersAdmin = str_replace('{email}', $adminEmail, $sqlUsersAdmin);
        $sqlUsersAdmin = str_replace('{pass}', password_hash($adminPass, PASSWORD_DEFAULT), $sqlUsersAdmin);
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