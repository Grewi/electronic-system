<?php
namespace system\core\model\traits;

trait delete
{
    private function delete($id = null): void
    {

        if(is_null($id) && is_null($this->{$this->_id})){
            $sql = 'DELETE FROM ' . $this->_table . ' ' . $this->_where;
            db()->query($sql, $this->_bind);
        }else{
            if($this->{$this->_id}){
                $this->where($this->{$this->_id});
            }            
            $sql = 'DELETE FROM ' . $this->_table . ' ' .  $this->_where;
            db()->query($sql, $this->_bind);
        }

    }
}