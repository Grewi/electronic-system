<?php
namespace system\core\view;
use system\core\view\view;

class viewStringReturn
{
    private $content;

    public function __construct($file, $data)
    {
        $this->content = (new view())->return($file, $data);
    }

    public function return() : string
    {
        return $this->content;
    }
}