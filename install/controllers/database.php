<?php
namespace system\install\controllers;
use system\core\validate\validate;

class database
{
    public static function users()
    {
        $valid = new validate();
        $valid->name('table-users')->bool();
        if($valid->control() && db() && $valid->return('table-users')){
            $sqlUsers = file_get_contents(SYSTEM . '/install/sql/users.sql');
            db()->query($sqlUsers);
        }
    }

    public static function sessions()
    {
        $valid = new validate();
        $valid->name('table-sessions')->bool();
        if($valid->control() && db() && $valid->return('table-sessions')){
            $sqlSessions = file_get_contents(SYSTEM . '/install/sql/sessions.sql');
            db()->query($sqlSessions);
        }        
    }
}