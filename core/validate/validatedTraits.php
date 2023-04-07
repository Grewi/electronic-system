<?php declare(strict_types=1);

namespace system\core\validate;
use system\core\database\database;
use system\core\csrf\csrf;

trait validatedTraits
{

    public function csrf(string $name): validate
    {
        $data = $this->data[$this->currentName];
        $a = null;
        if(isset($_SESSION['csrf'][$name])){
            $a = $_SESSION['csrf'][$name];
        }
        
        if ($data != $a) {
            $this->error[$this->currentName][] = lang( 'valid' ,'csrf');
            $this->setControl(false);
        }
        $this->setReturn($data);
        return $this;
    }

    public function empty(): validate
    {
        $data = $this->data[$this->currentName];
        if (empty(strip_tags($data ?? ''))) {
            $this->error[$this->currentName][] = lang('valid', 'noEmpty');
            $this->setControl(false);
        }
        $this->setReturn($data);
        return $this;
    }

    public function int(): validate
    {
        $data = $this->data[$this->currentName];
        if (!empty($data) && !preg_match("/^[0-9]+$/u", (string)$data)) {
            $this->error[$this->currentName][] = lang( 'valid' ,'noInt');
            $this->setControl(false);
        }
        $this->setReturn($data);
        return $this;
    }

    public function min(int $min): validate
    {
        $data = $this->data[$this->currentName];
        if (!empty($data) && $data < $min) {
            $this->error[$this->currentName][] = lang('valid', 'noMin');
            $this->setControl(false);
        }
        $this->setReturn($data);
        return $this;
    }   
    
    public function max(int $max): validate
    {
        $data = $this->data[$this->currentName];
        if (!empty($data) && $data > $max) {
            $this->error[$this->currentName][] = lang('valid', 'noMax');
            $this->setControl(false);
        }
        $this->setReturn($data);
        return $this;
    } 

    public function float(): validate 
    {
        $data = $this->data[$this->currentName];
        if (!empty($data) && !preg_match("/^[0-9\.\,]+$/u", (string)$data)) {
            $this->error[$this->currentName][] = lang('valid' ,'noInt');;
            $this->setControl(false);
        }
        $data = str_replace(',', '.', $data);
        $this->setReturn($data);
        return $this;
    }

    public function bool($bool = null) 
    {
        $data = $this->data[$this->currentName];
        if(!is_null($bool) && $bool && (bool)$bool != (bool)$data){
            $this->error[$this->currentName][] = lang('valid', 'boolTrue');
            $this->setControl(false);
        }
        if(!is_null($bool) && !$bool && (bool)$bool != (bool)$data){
            $this->error[$this->currentName][] = lang('valid', 'boolFalse');
            $this->setControl(false);
        }
        if($data){
            $this->setReturn(1);
        }else{
            $this->setReturn(0);
        }
        return $this;  
    }

    public function latRuInt(): validate
    {
        $data = $this->data[$this->currentName];
        if (!empty($data) && !preg_match("/^[\s a-zA-Z0-9а-яА-ЯёЁ\-_]+$/u", $data)) {
            $this->error[$this->currentName][] = lang('valid', 'latRuInt');
            $this->setControl(false);
        }
        $this->setReturn($data);
        return $this;
    }

    public function latInt(): validate
    {
        $data = $this->data[$this->currentName];
        if (!empty($data) && !preg_match("/^[\s a-zA-Z0-9\-_]+$/u", $data)) {
            $this->error[$this->currentName][] = lang('valid', 'latInt');
            $this->setControl(false);
        }
        $this->setReturn($data);
        return $this;
    }

    public function ru(): validate
    {
        $data = $this->data[$this->currentName];
        if (!empty($data) && !preg_match("/^[\s а-яА-ЯёЁ\.]+$/u", $data)) {
            $this->error[$this->currentName][] = lang('valid', 'ru');
            $this->setControl(false);
        }
        $this->setReturn($data);
        return $this;
    }

    public function mail(): validate
    {
        $this->data[$this->currentName] = $this->data[$this->currentName] ? mb_strtolower($this->data[$this->currentName]) : '';
        $data = $this->data[$this->currentName];
        if (!empty($data) && !preg_match("/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/u", $data)) {    
            $this->error[$this->currentName][] = lang('valid','mail');
            $this->setControl(false);
        }
        $this->setReturn($data);
        return $this;
    }

    public function tel(bool $clean = false): validate
    {
        $data = $this->data[$this->currentName];
        if (!empty($data) && preg_match("/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?([\d\- ]{7,10})$/u", $data)) {
            $this->error[$this->currentName][] = lang('valid', 'tel');
            $this->setControl(false);
        }
        $this->setReturn($this->currentName);
        return $this;
    }

    public function date(): validate
    {
        $this->data[$this->currentName] = !empty($this->data[$this->currentName]) ? $this->data[$this->currentName] : null;
        $data = $this->data[$this->currentName];
        if(!empty($data)){
            $test = explode('-', $data);
            $check = false;
            if(@checkdate((int)$test[1], (int)$test[2], (int)$test[0])){
                $check = true;
            }

            if (!preg_match("/^[0-9\-]+$/u", $data) && !$check) {
                $this->error[$this->currentName][] = lang('valid','date');
                $this->setControl(false);
            }
        }

        $this->setReturn($data);
        return $this;
    }

    public function text()
    {
        $data = $this->data[$this->currentName] ? htmlspecialchars($this->data[$this->currentName]) : '';
        $this->setReturn($data);
        return $this;        
    }

    /**
     * 
     * @param string $table Имя таблицы
     * @param string $col   Имя стобца
     * @param int $id       id исключение (0 если не требуется)
     * @return void
     */
    public function unique(string $table, string $col, int $id): validate
    {
        $data = $this->data[$this->currentName];
        $db = database::connect();
        
        $i = $db->fetch('SELECT COUNT(*) as `count`  FROM `' . $table . '` WHERE `' . $col . '` = :data AND id != :id', ['data'  => $data, 'id' => $id]);

        if (!empty($data) && !empty($i->count)) {
            $this->error[$this->currentName][] = lang('valid', 'unique');
            $this->setControl(false);
        }
        $this->setReturn($data);
        return $this;
    } 
    
    /**
     * 
     * @param string $table Имя таблицы
     * @param string $col   Имя стобца
     * @param int $id       id исключение (0 если не требуется)
     * @return void
     */
    public function id(string $table, string $col, int $id): validate
    {
        $data = $this->data[$this->currentName];
        
        $i = db()->fetch('SELECT COUNT(*) as `count`  FROM `' . $table . '` WHERE `' . $col . '` = :data AND id != :id', ['data'  => $data, 'id' => $id]);

        if (!empty($data) && empty($i->count)) {
            $this->error[$this->currentName][] = lang('valid', 'unique');
            $this->setControl(false);
        }
        $this->setReturn($data);
        return $this;
    }

    public function isset(string $table, string $col = 'id')
    {
        $data = $this->data[$this->currentName];
        $i = db()->fetch('SELECT COUNT(*) as count FROM ' . $table . ' WHERE ' . $col . ' = :data', ['data' => $data]);
        if(!(int)$i->count){
            $this->error[$this->currentName][] = 'Значение отсутствует';
            $this->setControl(false);  
        }
        return $this;
    }

    public function strlen($strlen)
    {
        $data = $this->data[$this->currentName];
        if (!empty($data) && mb_strlen((string)$data) != $strlen) {
            $this->error[$this->currentName][] = sprintf(lang('valid', 'strlen'), (string)$strlen);
            $this->setControl(false);
        }
        $this->setReturn($data);
        return $this;
    }

    public function strlenMin($strlen)
    {
        $data = $this->data[$this->currentName];
        if (!empty($data) && mb_strlen((string)$data) < $strlen) {
            $this->error[$this->currentName][] = sprintf(lang('valid', 'strlenMin'), (string)$strlen);
            $this->setControl(false);
        }
        $this->setReturn($data);
        return $this;
    }

    public function strlenMax($strlen)
    {
        $data = $this->data[$this->currentName];
        if (!empty($data) && mb_strlen((string)$data) > $strlen) {
            $this->error[$this->currentName][] = sprintf(lang('valid', 'strlenMax'), (string)$strlen);
            $this->setControl(false);
        }
        $this->setReturn($data);
        return $this;
    }
}