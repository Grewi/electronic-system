<?php 
namespace system\core\text;

class sanitizer
{
    public static function latInt($str)
    {
        return preg_replace('/[^a-zA-Z0-9]/ui', '', $str);
    }

    public static function latRuInt($str)
    {
        return preg_replace('/[^a-zA-Zа-яА-Я0-9]/ui', '', $str);
    }

    public static function float($str)
    {
        return preg_replace('/[^0-9.,]/ui', '', $str);
    }

    public static function int($str)
    {
        return preg_replace('/[^0-9]/ui', '', $str);
    }

    public static function date($str)
    {
        return preg_replace('/[^0-9-]/ui', '', $str);
    }

    public static function email($str)
    {
        return preg_replace('/[^@.a-zA-Zа-яА-Я0-9-_]/ui', '', $str);
    }
}