<?php 
namespace system\core\model\traits;

trait insert
{
    private function insert($data )
    {
        $count = count($data);
        $strKey = '';
        $strData = '';
        $c = 0;
        foreach($data as $key => $i){
            $c++;
            if($c == $count){
                $strKey .= ' `' . $key . '` ';
                $strData .= ' :' . $key . ' ';
            }else{
                $strKey .= ' `' . $key . '`, ';
                $strData .= ' :' . $key . ', ';
            }

        }
        $data = array_merge($data,$this->_bind);
        $sql = 'INSERT INTO ' . $this->_table . ' (' . $strKey .') VALUES (' . $strData . ')';
        db($this->_databaseName)->query($sql, $data);
        try{

            if (config('database', 'type') == 'sqlite') {
                $dbId = db($this->_databaseName)->fetch('SELECT Last_insert_rowid() as ' . $this->_id, []);
            }else{
                $dbId = db($this->_databaseName)->fetch('SELECT * FROM ' . $this->_table . ' where ' . $this->_id .' = LAST_INSERT_ID()', []);
            }

            $ob = static::class;
            $result = $ob::find($dbId->{$this->_id});
            return $result ? $result : null;
        }catch(\Exception $e){
            return null;
        }
        
    }
}