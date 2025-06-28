<?php
namespace system\console;

class config
{
    private $dir = [];
    private $path = APP . '/configs/';

    public function actual() : void
    {
        $this->scan();
        $this->comparison();
        echo "Файлы конфигураций обновленны! \n";
    }

    private function scan() : void
    {
        $dir = scandir($this->path);
        foreach($dir as $i){
            if($i == '.' || $i == '..'){
                continue;
            }
            
            if(file_exists($this->path . $i)){
                $file = pathinfo($this->path . $i);
                if($file['extension'] == 'php'){
                    $this->dir[] = $file['filename'];
                }
            }
        }
    }

    private function comparison() : void
    {
        
        foreach($this->dir as $i){
            $ini = [];
            if(file_exists($this->path . '.' . $i . '.ini')){
                $ini = parse_ini_file($this->path . '.' . $i . '.ini');
            }else{
                $class = '\\' . APP_NAMESPACE . '\\configs\\' . $i;
                $configs = new $class();
                $php = $configs->set();
                $result = array_merge($php, $ini);
                $ini = '';
                foreach ($result as $key => $ii) {
                    
                    $ini .= $key . ' = ' . $ii . PHP_EOL;
                }
            }

            file_put_contents($this->path . '.' . $i . '.ini', $ini);
        }
    }
}