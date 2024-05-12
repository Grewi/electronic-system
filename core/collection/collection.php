<?php

namespace system\core\collection;

#[\AllowDynamicProperties]
class collection 
{
    private $data = [];

    public function set( array $param)
    {
        foreach($param as $a => $i){
            $this->data[$a] = $i;
        }
    }

    public function __get($name)
    {
        return $this->data[$name];
    }

    public function __invoke()
    {
        return $this->data;
    }

    public function all()
    {
        return $this->data;
    }
} 