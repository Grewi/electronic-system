<?php
namespace system\core\validate;

trait toTrait{
    public function toInt() : void
    {
        $data = $this->data[$this->currentName];
        $this->setReturn((int)$data);
    }

    public function toFloat() : void
    {
        $data = $this->data[$this->currentName];
        $this->setReturn((float)$data);
    }

    public function toString() : void
    {
        $data = $this->data[$this->currentName];
        $this->setReturn((string)$data);
    }
}