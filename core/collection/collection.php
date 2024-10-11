<?php

namespace system\core\collection;

#[\AllowDynamicProperties]
class collection 
{

    public function set( array $param)
    {
        foreach($param as $a => $i){
            $this->$a = $i;
        }
    }

    public function __get($name) : void
    {

    }
} 