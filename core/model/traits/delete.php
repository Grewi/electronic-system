<?php
namespace system\core\model\traits;

trait delete
{
    private function delete($id = null): void
    {

        if(is_null($id)){
            $sql = 'DELETE FROM ' . $this->_table . ' ' . $this->_where;
            db()->query($sql, $this->_bind);
        }else{
            if($this->_id){
                $this->where($this->_id);
            }            
            $sql = 'DELETE FROM ' . $this->_table . ' WHERE `' . $this->_id . '` = ' . $id;
            db()->query($sql, [$this->_id => $id]);
        }

    }
}