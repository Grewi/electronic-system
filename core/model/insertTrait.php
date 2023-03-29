<?php 
namespace system\core\model;
use system\core\database\database;

trait insertTrait
{
    private function insert(array $data )
    {
        $db = database::connect();
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
        $db->query($sql, $data);
        try{
            $dbId = $db->fetch('SELECT * FROM ' . $this->_table . ' where ' . $this->_id .' = LAST_INSERT_ID()', []);
            $ob = static::class;
            return $ob::find($dbId->id);
        }catch(\Exception $e){
            return null;
        }
        
    }
}