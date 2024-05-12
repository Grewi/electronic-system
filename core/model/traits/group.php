<?php 
namespace system\core\model\traits;

trait group
{
    public function group($name)
    {
        $str = ' GROUP BY `' . $name . '` ';
        $this->_group = $str;
        return $this;
    }
}