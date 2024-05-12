<?php
namespace system\core\model\traits;

trait save
{
    public function save(array $data = [])
    {
        $arr = [];
        foreach($this as $a => $i){
            try{
                $m = new \ReflectionProperty($this, $a);
                $modificator = \Reflection::getModifierNames($m->getModifiers());
                if($modificator[0] == 'public'){
                    $arr[$a] = $i;
                }                
            }catch(\Exception $e){}
        }
        $arr = array_merge($arr, $data);
        $result = $this->update($arr);
        return $result ? $result : null;
    }
}