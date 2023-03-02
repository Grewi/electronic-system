<?php
namespace system\core\model;

trait saveTrait
{
    protected function save($data = [])
    {
        $arr = [];
        foreach($this as $a => $i){
            $m = new \ReflectionProperty($this, $a);
            $modificator = \Reflection::getModifierNames($m->getModifiers());
            if($modificator[0] == 'public'){
                $arr[$a] = $i;
            }
        }
        $arr = array_merge($arr, $data);
        return $this->update($arr);
    }
}