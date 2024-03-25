<?php
namespace system\core\app;
use system\core\traits\singleton;
use system\core\collection\collection;

class app{
    private static $connect = null;
    private $collections = [];

    static public function app()
    {
		if(self::$connect === null){ 
			self::$connect = new self();
		}
		return self::$connect;
	}

    public function __get($name)
    {
        if(!isset($this->collections[$name])){
            $this->collections[$name] = new collection();
        }
        return $this->collections[$name];
    }
    
}