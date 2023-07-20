<?php 

namespace system\console;

class createModel
{
    private $className = '';
    private $path = '';
    private $pathDir = '';
    private $namespace = '';

    public function index()
    {
        $parametr = ARGV[2];
        $ArrParam = explode('/', $parametr);
        $this->className = array_pop($ArrParam);
        $this->path = MODELS . '/' . $parametr . '.php';
        $this->pathDir = MODELS . '/' . implode('/', $ArrParam) ;
        $modelPath = str_replace(ROOT . '/', '', MODELS);
        $modelPath = str_replace('/', '\\', $modelPath);
        $ArrParam = array_merge([$modelPath], $ArrParam);
        $this->namespace = implode('\\', $ArrParam) ;
        $this->save();
    }

    private function save()
    {
        if(!file_exists($this->path)){

            if(!file_exists($this->pathDir)){
                mkdir($this->pathDir, 0755, true);
            }
            file_put_contents($this->path, $this->layout());
        }
    }

    private function layout()
    {
return "<?php 
namespace " . $this->namespace . ";
use electronic\core\model\model;

class " . $this->className . " extends model
{

}
";
    }
}