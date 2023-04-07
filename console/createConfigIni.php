<?php
namespace system\console;

class createConfigIni
{
    public function index() : void
    {
        $path = APP . '/configs';
        if(file_exists($path)){
            $allFiles = scandir($path);
            foreach($allFiles as $a => $i){
                if($i == '.' || $i == '..'){
                    continue;
                }
                $info = pathinfo($i);
                if($info['extension'] != 'php'){
                    continue;
                }
                $filename = $info['filename'];
                \system\core\config\config::createConfig($filename);
            }
            echo 'Процесс завершён.' . PHP_EOL;
        }
    }
}