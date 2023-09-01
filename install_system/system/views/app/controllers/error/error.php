<?php
namespace app\controllers\error;

use app\controllers\controller;
use electronic\core\view\view;

class error extends controller
{
    public function error404()
    {
        http_response_code(404);
        $this->typeStr();
        new view('error/error404', $this->data);
    }

    private function typeStr()
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