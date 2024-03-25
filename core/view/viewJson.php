<?php
namespace system\core\view;
use system\core\view\view;

class viewJson 
{
    public function __construct($file, $data)
    {
        $content = (new view())->return($file, $data);
        echo json_encode($content);
    }
}