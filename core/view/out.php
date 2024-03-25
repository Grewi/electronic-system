<?php 
namespace system\core\view;
use system\core\view\view;

class out
{
    public static function string($view, $data)
    {
        $content = (new view())->return($view, $data);
        echo $content;
    }

    public static function json($view, $data)
    {
        $content = (new view())->return($view, $data);
        echo json_encode($content);
    }   
}