<?php
namespace system\core\error;
use system\core\history\history;
use system\core\app\app;

trait error404 
{
    protected $ErrorTextResponse = "Page not found";

    protected function errorResponse()
    {
        $app = app::app();
        http_response_code(404);
        history::shift();
        $this->errorTypeStr();
        if($app->bootstrap->ajax){
            exit($this->ErrorTextResponse);
        }
    }

    protected function errorTypeStr()
    {
        $ex = explode('/', request('global')->uri);
        $el = array_pop($ex);
        $el = pathinfo(request('global')->uri);
        $img = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'ico'];
        $data = ['css', 'js', 'txt', 'html'];
        $file = ROOT . '/files/no-img.jpg';

        if (isset($el['extension'])) {
            $name = mb_strtolower($el['extension']);
            if (in_array($name, $img)) {
                $type = 'image/jpeg';
                header('Content-Type:' . $type);
                header('Content-Length: ' . filesize($file));
                readfile($file);
                exit();
            }else{
                exit();
            }
        }
    }
}