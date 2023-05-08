<?php

namespace system\core\database;

use system\core\config\config;
use system\core\database\cacheQuery;
use system\core\traits\singleton;

class database
{

    /** @var \PDO */
    private $pdo;
    private static $db;

    use singleton;

    /** @var Подключение к базе */
    private function __construct()
    {
        try {
            if (config::database()->type == 'sqlite') {
                $options = [
                    \PDO::ATTR_EMULATE_PREPARES => false,
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
                ];
                if (file_exists(ROOT . '/sqlite/' . config::database('file_name') . '.db')) {
                    $this->pdo = new \PDO('sqlite:' . ROOT . '/sqlite/' . config::database('file_name') . '.db', '', '', $options);
                } else {
                    exit('Ошибка подключения к БД');
                }
            } else if (in_array(config::database()->type, ['mysql', 'pgsql'])) {
                $this->pdo = new \PDO(
                    config::database()->type . ':host=' . config::database('host') . ';dbname=' . config::database('name'),
                    config::database('user'),
                    config::database('pass')
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

    private function fetchAll(string $sql, array $params = null, string $className = 'stdClass')
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

    private function fetch(string $sql, array $params = null, string $className = 'stdClass')
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
}
