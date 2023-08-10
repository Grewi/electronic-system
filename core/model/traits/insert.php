<?php 
namespace system\core\model\traits;

trait insert
{
    private function insert($data )
    {
        $count = count($data);
        $str = '';
        $c = 0;
        foreach($data as $key => $i){
            $c++;
            if($c == $count){
                $str .= ' `' . $key . '` = :' . $key . ' ';
            }else{
                $str .= ' `' . $key . '` = :' . $key . ', ';
            }

        }
        $data = array_merge($data,$this->_bind);
        $sql = 'INSERT INTO ' . $this->_table . ' SET ' . $str;
        db()->query($sql, $data);
        try{
            $dbId = db()->fetch('SELECT * FROM ' . $this->_table . ' where ' . $this->_id .' = LAST_INSERT_ID()', []);
            $ob = static::class;
            $result = $ob::find($dbId->{$this->_id});
            return $result ? $result : null;
        }catch(\Exception $e){
            return null;
        }
        
    }
}