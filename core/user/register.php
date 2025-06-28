<?php
namespace system\core\user;

class register
{
    public static function password($pass)
    {
        return password_hash($pass, PASSWORD_DEFAULT);
    }
}