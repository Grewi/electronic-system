<?php declare(strict_types=1);

namespace system\core\lang;
use system\core\traits\singleton;
use system\core\config\config;

class lang 
{
    private static $connect = null;
    private $default = 'ru';

    use singleton;

    private function __construct()
    {
        $l = config::globals('lang');
        if($l){
           $this->default = $l;
        }
    }

    public static function __callStatic($name, $arguments)
    {
        $lex = $arguments[0];
        if(!isset($arguments[0]) || empty($arguments[0])){
            return $lex;
        }
        
        $file = ROOT . '/app/lang/' . (new static)->default . '/' . $name . '.php';
        $str = '';
        if(file_exists($file)){
            $langs = require $file;
            if(isset($langs[$lex])){
                $str = $langs[$lex];
            }
        }

        if(empty($str)){
            return $lex;
        }else{
            return $str;
        }
    }

}