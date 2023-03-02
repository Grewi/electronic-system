<?php declare(strict_types=1);

namespace system\core\request;
use system\core\collection\collection;

class request
{
    private static $connect = null;

    static public function connect() : request
    {
		if(self::$connect === null){
			self::$connect = new self();
		}
		return self::$connect;
	}

    public function __get($name)
    {
        $this->$name = new collection;
        return $this->$name;
    }

    public function _get($name = null)
    {
        if($name){
            return $this->$name;
        }else{
            return $this;
        }
    }

    private function _set(string $name, array $data)
    {
        if(property_exists($this, $name)){
            $this->$name->set($data);
        }else{
            $collection = new collection();
            $collection->set($data);
            $this->$name = $collection;            
        }
    }

    public static function __callStatic($method, $parameters)
    {
        $m = '_' . $method;
        if(method_exists(self::$connect, $method)){
            return self::$connect->$method(...$parameters);
        }elseif(method_exists((new static), $m)){
            return self::$connect->$m(...$parameters);
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