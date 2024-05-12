<?php 
namespace app\controllers;

use app\models\images;
use app\models\image_size;
use app\controllers\controller;

class imagesController extends controller
{
    public function icon()
    {
        $this->up('icon');
    }

    public function mini()
    {
        $this->up('mini');
    }

    public function normal()
    {
        $this->up('normal');
    } 
    
    public function big()
    {
        $this->up('big');
    }     

    private function up($size)
    {
        
        $name = request('get', 'name');
        $id = preg_replace('/[^0-9]/ui', '', $name);
        if(!file_exists(ROOT . '/public/images/original/' . $id . '.png')){
            http_response_code(404);
            exit('404');
        }

        if(file_exists(ROOT . '/public/images/thumbnail/' . $size . '/' . $id . '.png')){
            $file = ROOT . '/public/images/thumbnail/' . $size . '/' . $id . '.png';
            $type = 'image/png';
            header('Content-Type:'.$type);
            header('Content-Length: ' . filesize($file));
            readfile($file);
            exit();
        }   

        $image = (new images)->find($id);
        $s = (new image_size)->where('slug', $size)->get();

        if(!$s){
            http_response_code(404);
            exit('no size');
        }

        $fn = $image->id . '.png';
        $handle = new \Verot\Upload\Upload(ROOT . '/public/images/original/' . $image->id . '.png', 'ru_RU');
        
        if ($handle->uploaded) {
            $handle->dir_chmod            = 0755;
            $handle->allowed              = ['image/*'];
            $handle->image_convert        = 'png';
            $handle->file_new_name_body   = $image->id;
            $handle->image_x              = $s->size;
            $handle->image_y              = $s->size;
            $handle->image_resize         = true;
            $handle->image_ratio_y        = true;
            $handle->image_no_enlarging   = true;
            $handle->file_max_size        = '250308500';
            $handle->process(ROOT . '/public/images/thumbnail/' . $size . '/');
            
        }

        if ($handle->processed && file_exists(ROOT . '/public/images/thumbnail/' . $size . '/' . $fn)) {
            $file = ROOT . '/public/images/thumbnail/' . $size . '/' . $fn;
            $type = 'image/png';
            header('Content-Type:'.$type);
            header('Content-Length: ' . filesize($file));
            readfile($file);
            exit();
        }else{
            echo 'error : ' . $handle->error;
            http_response_code(404);
            exit();
        }
    }
}
