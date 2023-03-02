<?php
namespace system\console;

class config
{
    private $dir = [];
    private $path = ROOT . '/app/configs/';

    public function actual()
    {
        $this->scan();
        $this->comparison();
        echo "Файлы конфигураций обновленны! \n";
    }

    private function scan()
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

    private function comparison(){
        foreach($this->dir as $i){
            if(file_exists($this->path . '.' . $i . '.ini')){
                $ini = parse_ini_file($this->path . '.' . $i . '.ini');
            }else{
                continue;
            }

            $class = '\\app\\configs\\' . $i;
            $configs = new $class();
            $php = $configs->set();
            $result = array_merge($php, $ini);
            $ini = '';
            foreach ($result as $key => $ii) {
                
                $ini .= $key . ' = ' . $ii . PHP_EOL;
            }
            file_put_contents($this->path . '.' . $i . '.ini', $ini);
        }
    }
}