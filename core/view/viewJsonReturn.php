<?php
namespace system\core\view;
use system\core\view\view;

class viewJsonReturn
{
    private $content;

    public function __construct($file, $data)
    {
        $this->content = (new view())->return($file, $data);
    }

    public function return() : string
    {
        return json_encode($this->content);
    }
}