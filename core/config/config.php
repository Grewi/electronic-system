<?php

namespace system\core\config;

class config
{
    private $path = ROOT . '/app/configs/';
    private $element = '';
    private $iniArr = [];
    private $phpArr = [];
    private static $connect = null;

    static public function connect()
    {
		if(self::$connect === null){ 
			self::$connect = new self();
		}
		return self::$connect;
	}

    public static function __callStatic($element, $parameters)
    {
        if($element == 'createConfig'){
            self::connect()->createConfig($parameters[0]);
        }
        return self::connect()->m($element, $parameters);
    }

    public function __get($parameters){
        return self::connect()->m($this->element, [$parameters]);
    }

    private function m(string $element, array $param = null){
        $this->iniArr = [];
        $this->element = $element;
        $ini = $this->path . '.' . $element . '.ini';
        $php = $this->path . $element . '.php';

        //Парсим ini файл
        if (file_exists($ini)) {
            $this->iniArr = parse_ini_file($ini);
        }

        //Если есть значение в ini возвращаем его
        if ($param && isset($this->iniArr[$param[0]])) {
            return $this->iniArr[$param[0]];
        }

        //Парсим php файл, если есть значение, возвращаем
        if ($param && file_exists($php)) {
            $this->createConfigFile($element);
            $this->iniArr = parse_ini_file($ini);
            //Если есть значение в ini возвращаем его
            if ($param && isset($this->iniArr[$param[0]])) {
                return $this->iniArr[$param[0]];
            }else{
                return null;
            }
        }elseif($param){
            return null;
        }

        return $this;
    }

    private function createConfigFile(string $className): void
    {
        $class = '\\app\\configs\\' . $className;
        $a = new $class;
        $config = $a->set();
        $config = array_merge($config, $this->iniArr);
        $this->iniArr = $config;
        $ini = '';
        foreach ($config as $key => $i) {
            $ini .= $key . ' = ' . $i . PHP_EOL;
        }
        file_put_contents($this->path . '.' . $className . '.ini', $ini);
    }

    //Метод для обновления ini файлов
    private function createConfig(string $className): void
    {
        $class = '\\app\\configs\\' . $className;
        $a = new $class;
        $config = $a->set();

        $i = $this->path . '.' . $className . '.ini';
        if (file_exists($i)) {
            $this->iniArr = parse_ini_file($i);
        }

        $config = array_merge($config, $this->iniArr);
        $this->iniArr = $config;
        $ini = '';
        foreach ($config as $key => $i) {
            $ini .= $key . ' = ' . $i . PHP_EOL;
        }
        file_put_contents($this->path . '.' . $className . '.ini', $ini);
        $this->iniArr = [];
    }
}
