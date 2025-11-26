<?php
namespace system\core\validate;

trait toTrait{
    public function toInt() : void
    {
        $data = $this->data[$this->currentName];
        $this->return[$this->currentName] = (int)$data;
    }

    public function toFloat() : void
    {
        $data = $this->data[$this->currentName];
        $this->return[$this->currentName] = (float)$data;
    }

    public function toString() : void
    {
        $data = $this->data[$this->currentName];
        $this->return[$this->currentName] = (string)$data;
    }
	
	public function toNull() : void
    {
        $data = $this->data[$this->currentName];
        if(empty($data)){
            $this->setReturn(null);
        }
    }
}