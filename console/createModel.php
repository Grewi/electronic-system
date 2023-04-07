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
        $this->path = APP . '/models/' . $parametr . '.php';
        $this->pathDir = APP . '/models/' . implode('/', $ArrParam) ;
        $ArrParam = array_merge([APP_NAME, 'models'], $ArrParam);
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
    public function index()
    {

    }
}
";
    }
}