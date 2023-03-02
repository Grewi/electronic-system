<?php 

namespace system\console;

class createModel
{
    public function index()
    {
        $parametr = ARGV[2];
        $ArrParam = explode('/', $parametr);
        $this->className = array_pop($ArrParam);
        $this->path = ROOT . '/app/models/' . $parametr . '.php';
        $this->pathDir = ROOT . '/app/models/' . implode('/', $ArrParam) ;
        $ArrParam = array_merge(['app', 'models'], $ArrParam);
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
use system\core\model\model;

class " . $this->className . " extends model
{
    public function index()
    {

    }
}
";
    }
}