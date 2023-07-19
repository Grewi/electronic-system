<?php
namespace system\install_system\view;
use system\core\view\view;

class viewStringReturn extends view
{
    private $return;

    public function out(array $data) : void
    {
        
        if(file_exists($this->cacheDir . '/' . $this->filePath . '.php')){
            ob_start();
            extract($data);
            require $this->cacheDir . '/' . $this->filePath . '.php';
            $content = ob_get_contents();
            ob_end_clean();
            $this->return = $content;
        }else{
            throw new \TempException('Отсутствует файл вывода для шаблона "' . $this->filePath . '"!');
        }
    }

    public function return() : string
    {
        return $this->return;
    }
}