<?php
namespace system\core\model;
use system\core\database\database;

trait deleteTrait
{
    private function delete(int $id = null)
    {
        if($this->id){
            $this->where($this->id);
        }
        if(is_null($id)){
            $db = database::connect();
            $sql = 'DELETE FROM ' . $this->_table . ' ' . $this->_where;
            $db->query($sql, $this->_bind);
        }else{
            $db = database::connect();
            $sql = 'DELETE FROM ' . $this->_table . ' WHERE `' . $this->_id . '` = ' . $id;
            $db->query($sql, [$this->_id => $id]);
        }

    }
}