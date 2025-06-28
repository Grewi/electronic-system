<?php 
namespace system\core\traits;

trait singleton
{
    private static $connect = null;

    static public function connect()
    {
		if(self::$connect === null){ 
			self::$connect = new self();
		}
		return self::$connect;
	}

    public static function __callStatic($method, $parameters)
    {
        $m = '_' . $method;
        if(method_exists(self::connect(), $method)){
            return self::connect()->$method(...$parameters);
        }elseif(method_exists(self::connect(), $m)){
            return self::connect()->$m(...$parameters);
        }
    }

    public function __call($method, $param)
    {
        $m = '_' . $method;
        if(method_exists($this, $method)){
            return $this->$method(...$param);
        }elseif(method_exists($this, $m)){
            return $this->$m(...$param);
        }
    }
}