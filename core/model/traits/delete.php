<?php
namespace system\core\model\traits;

trait delete
{
    private function delete($id = null): void
    {
        if(!empty($id) && !empty($this->{$this->_id})){
            $sql = 'DELETE FROM ' . $this->_table . ' ' . $this->_where;
            db($this->_databaseName)->query($sql, $this->_bind);
        }else{
            if(!empty($this->{$this->_id})){
                $this->where($this->{$this->_id});
            }            
            $sql = 'DELETE FROM ' . $this->_table . ' ' .  $this->_where;
            db($this->_databaseName)->query($sql, $this->_bind);
        }
    }
}