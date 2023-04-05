<?php
namespace system\core\logs;
use app\models\logs_type;
use app\models\logs as logsModel;
use system\core\config\config;

//data - json 
//Данные: 
// Title
// Description
// Data служебные данные

class logs
{
    private static $connect = null;
    private $slug = null;
    private $name = null;
    private $description = null;
    private $userId = null;
    private $logConfig = false;

    private function __construct()
    {
        $this->logConfig = (bool)config::globals('logs');
    }

    static public function connect() : logs
    {
		if(self::$connect === null){
			self::$connect = new self();
		}
		return self::$connect;
	}

    public function _name(string $slug, string $name) : logs
    {
        $this->slug = $slug;
        $this->name = $name;
        return $this;
    }

    public function _description(string $description = null) : logs
    {
        $this->description = $description;
        return $this;
    }

    public function _userId($userId) : logs
    {
        $this->userId = $userId;
        return $this;
    }

    public function _insert($data = null) : void
    {
        if($this->logConfig && $this->slug && $this->name){
            $type = logs_type::where('slug', $this->slug)->get();
            if(!$type){
                $typeData = [
                    'name' => $this->name,
                    'slug' => $this->slug,
                ];
                logs_type::insert($typeData);
            }
            if(user_id()){
                $userId = user_id();
            }else{
                $userId = $this->userId;
            }
            $t = logs_type::where('slug', $this->slug)->get();
            $d = [
                'type_id'      => $t ? $t->id : null,
                'user_id'      => $userId,
                'session_key'  => $_SESSION['us'],
                'request_type' => $_SERVER['REQUEST_METHOD'],
                'request_url'  => $_SERVER['REQUEST_URI'],
                'description'  => $this->description,
                'data'         => json_encode($data),       
            ]; 

            logsModel::insert($d);
        }

    }

    public static function __callStatic($method, $parameters)
    {
        $m = '_' . $method;
        if(method_exists((new static), $method)){
            return (new static)->$method(...$parameters);
        }elseif(method_exists((new static), $m)){
            return (new static)->$m(...$parameters);
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