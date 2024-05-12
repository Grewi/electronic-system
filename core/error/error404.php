<?php
namespace system\core\error;
use system\core\history\history;
use system\core\app\app;

trait error404 
{
    protected $ErrorTextResponse = "Page not found | Error 404";
    protected $noImgFile = __DIR__ . '/noimage.jpeg';
    protected $imagesFormat = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'ico'];

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

        if (isset($el['extension'])) {
            $name = mb_strtolower($el['extension']);
            if (in_array($name, $this->imagesFormat)) {
                $type = 'image/jpeg';
                header('Content-Type:' . $type);
                header('Content-Length: ' . filesize($this->noImgFile));
                readfile($this->noImgFile);
                exit();
            }else{
                exit($this->ErrorTextResponse);
            }
        }
    }
}