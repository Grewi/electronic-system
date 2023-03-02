<?php declare(strict_types=1);

namespace system\core\lang;

class lang 
{
    private static $connect = null;
    private $default = 'ru';

    private function __construct()
    {

    }

    static public function connect() : lang
    {
		if(self::$connect === null){
			self::$connect = new self();
		}
		return self::$connect;
	}

    public function return( string $fileName, string $lex, array $param = []) : string
    {
        $file = ROOT . '/app/lang/' . $this->default . '/' . $fileName . '.php';
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