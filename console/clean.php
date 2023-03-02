<?php

namespace system\console;

class clean
{
    public function index()
    {
        $this->cleanConfig();
        $this->cleanCache();
    }

    public function cleanConfig()
    {
         $dirConfigs = scandir(ROOT . '/app/configs/');
         foreach($dirConfigs as $i){
            if(substr($i, -4) == '.ini'){
                unlink(ROOT . '/app/configs/' . $i);
            }
         }        
    }

    public function cleanCache()
    {
        $dirCache = scandir(ROOT . '/app/cache/views/');
        foreach($dirCache as $i){
           if($i != '.' && $i != '..'){
               $this->deleteDir(ROOT . '/app/cache/views/' . $i);
           }
        }
    }

    private function deleteDir($dirPath) {
        if (! is_dir($dirPath)) {
            throw new \InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }
}