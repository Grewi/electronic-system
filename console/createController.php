<?php 

namespace system\console;

class createController
{
    private $parametr;
    private $className;
    private $path;
    private $path_v;
    private $pathDir;
    private $pathDir_v;
    private $namespace;

    public function index()
    {
        $parametr = ARGV[2];
        $this->parametr = $parametr;
        $v = ARGV[3];

        $ArrParam = explode('/', $parametr);
        $this->className = array_pop($ArrParam) . 'Controller';
        $this->path = ROOT . '/app/controllers/' . $parametr . 'Controller.php';
        $this->pathDir = ROOT . '/app/controllers/' . implode('/', $ArrParam);
        $_ArrParam = array_merge(['app', 'controllers'], $ArrParam);
        $this->namespace = implode('\\', $_ArrParam) ;
        $this->save();

        if($v){
            $this->path_v = ROOT . '/app/views/' . $parametr . '.php';
            $this->pathDir_v = ROOT . '/app/views/' . implode('/', $ArrParam);
            $this->save_v();
        }
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

    private function save_v()
    {
        if(!file_exists($this->path_v)){

            if(!file_exists($this->pathDir_v)){
                mkdir($this->pathDir_v, 0755, true);
            }
            file_put_contents($this->path_v, '');
        }
    }

    private function layout()
    {
return "<?php 
namespace " . $this->namespace . ";
use app\controllers\controller;
use system\core\\view\\view;

class " . $this->className . " extends controller
{
    public function index()
    {
        \$this->title('');
        new view('" . $this->parametr . "', \$this->data);
    }
}
";
    }
}