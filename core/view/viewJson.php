<?php
namespace system\core\view;
use system\core\view\view;

class viewJson extends view
{
    public function out(array $data) : void
    {
        
        if(file_exists($this->cacheDir . '/' . $this->filePath . '.php')){
            ob_start();
            extract($data);
            require $this->cacheDir . '/' . $this->filePath . '.php';
            $content = ob_get_contents();
            ob_end_clean();
            echo json_encode($content);
        }else{
            throw new \TempException('Отсутствует файл вывода для шаблона "' . $this->filePath . '"!');
        }
    }
}