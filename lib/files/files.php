<?php

namespace system\lib\files;

class files
{
    public function __construct()
    {
        require __DIR__ . '/vendor/autoload.php';
    }

    public function test($file)
    {
        require __DIR__ . '/vendor/autoload.php';

        $handle = new \Verot\Upload\Upload($file);
        dump(0);
        if ($handle->uploaded) {
            dump(1);
            $handle->file_new_name_body   = 'image_resized';
            $handle->image_resize         = true;
            $handle->image_x              = 100;
            $handle->image_ratio_y        = true;
            $handle->process(ROOT . '/style/upload');
            if ($handle->processed) {
                dump(2);
                echo 'image resized';
                $handle->clean();
            } else {
                dump(3);
                echo 'error : ' . $handle->error;
            }  
        }
        echo $handle->log;
    }
}
