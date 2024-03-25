<?php

namespace system\core\database;

use system\core\config\config;
use system\core\database\cacheQuery;
use system\core\traits\singleton;

#[\AllowDynamicProperties]
class database
{

    /** @var \PDO */
    private $pdo;
    private static $db;
    private static $connect = [];

    private $type = '';
    private $file_name = '';
    private $host = '';
    private $name = '';
    private $user = '';
    private $pass = '';

    static public function connect($configName = null)
    {
        if(!$configName){
            $configName = 'database';
        }
		if(!isset(self::$connect[$configName]) || self::$connect[$configName] === null){ 
			self::$connect[$configName] = new self($configName);
		}
		return self::$connect[$configName];
	}

    /** @var Подключение к базе */
    private function __construct($configName)
    {
        $this->config($configName);
        try {
            if ($this->type == 'sqlite') {
                $options = [
                    \PDO::ATTR_EMULATE_PREPARES => false,
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
                ];
                if (file_exists(ROOT . '/sqlite/' . $this->file_name . '.db')) {
                    $this->pdo = new \PDO('sqlite:' . ROOT . '/sqlite/' . $this->file_name . '.db', '', '', $options);
                } else {
                    exit('Ошибка подключения к БД');
                }
            } else if (in_array($this->type, ['mysql', 'pgsql'])) {
                $this->pdo = new \PDO(
                    $this->type . ':host=' . $this->host . ';dbname=' . $this->name  . '; charset=utf8mb4',
                    $this->user,
                    $this->pass
                );
                //$this->pdo->exec('SET NAMES UTF8');
                if (config::globals('dev')) {
                    $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                }
            } else {
		throw new \PDOException('Неизвестный тип БД');
            }
        } catch (\PDOException $e) {
            dd('Ошибка подключения к БД: ' . $e->getMessage());
        }
    }

    private function config($name)
    {
        $config = config::$name();
        if(!$config){
            exit('Не установленны настройки для подключения к базе данных');
        }
        $this->file_name = $config->file_name;
        $this->type = $config->type;
        $this->name = $config->name;
        $this->host = $config->host;
        $this->user = $config->user;
        $this->pass = $config->pass;
    }

    private function query(string $sql, array $params = [], string $className = 'stdClass')
    {
        $sth = $this->pdo->prepare($sql);
        foreach ($params as $param => &$value) {
            $sth->bindParam(':' . $param, $value);
        }
        $sth->setFetchMode($this->pdo::FETCH_CLASS, $className);
        $sth->execute();
        return $sth;
    }

    private function fetchAll(string $sql, array $params = [], string $className = 'stdClass')
    {
        cacheQuery::addKey($sql, $params);
        if (!cacheQuery::control()) {
            $r = $this->query($sql, $params, $className)->fetchAll();
            cacheQuery::addQuery($r);
            return $r;
        } else {
            return cacheQuery::returnQuery();
        }
    }

    private function fetch(string $sql, array $params = [], string $className = 'stdClass')
    {
        cacheQuery::addKey($sql, $params);
        if (!cacheQuery::control()) {
            $r = $this->query($sql, $params, $className)->fetch();
            cacheQuery::addQuery($r);
            return $r;
        }else{
            return cacheQuery::returnQuery();
        }
    }

    private function transaction()
    {
        $this->pdo->beginTransaction();
    }

    private function commit()
    {
        $this->pdo->commit();
    }

    private function rollBack()
    {
        $this->pdo->rollBack();
    }

    private function errorCode()
    {
        return $this->pdo->errorCode();
    }

    private function errorInfo()
    {
        return $this->pdo->errorInfo();
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
