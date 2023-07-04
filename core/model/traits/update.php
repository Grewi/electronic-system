<?php 
namespace system\core\model\traits;

trait update
{
    private function update($data)
    {
        if(is_object($data)){
            $data = get_object_vars($data);
        }
        if(isset($data[$this->_id])){
            $this->where($data[$this->_id]);
            unset($data[$this->_id]);
        }
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
        
        $data = array_merge($data, $this->_bind);
        $sql = 'UPDATE ' . $this->_table . ' SET ' . $str . $this->_where;
        db()->query($sql, $data);
        try{
            if($this->_idNumber){
                $dbId = db()->fetch('SELECT * FROM ' . $this->_table . ' WHERE `' . $this->_id . '` = ' . $this->_idNumber . ';', []);
                $ob = static::class;
                $result = $ob::find($dbId->id);
                return $result ? $result : null;
            }
        }catch(\Exception $e){
            return null;
        }
    }
    
}