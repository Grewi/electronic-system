<?php
namespace system\core\database;
use system\core\traits\singleton;

#[\AllowDynamicProperties]
class cacheQuery
{
    use singleton;

    private $data = [];
    public $key = '';


    private function _addKey($sql, $params)
    {
        $this->key = $this->sanitizer($sql);
        foreach($params as $i){
            $this->key .= $this->sanitizer($i);
        }
        return $this;
    }

    private function _control()
    {
        return false;
        if(isset($this->data[$this->key])){
            return true;
        }else{
            return false;
        }
    }

    private function _addQuery($data)
    {
        $this->data[$this->key] = $data;
    }

    private function _returnQuery()
    {
        if(isset($this->data[$this->key])){
            return $this->data[$this->key];
        }else{
            return null;
        }
    }

    private function sanitizer($str){
        return preg_replace('/[^a-zA-Z0-9\<\>\=]/ui', '', $str ?? '');
    }
}