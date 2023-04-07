<?php 

namespace system\console;

class createConfig
{
    private $className = '';
    private $path = '';
    private $pathDir = '';
    private $namespace = '';

    public function index() : void
    {
        $parametr = ARGV[2];
        $ArrParam = explode('/', $parametr);
        $this->className = array_pop($ArrParam);
        $this->path = APP . '/configs/' . $parametr . '.php';
        $this->pathDir = APP . '/configs/' . implode('/', $ArrParam) ;
        $ArrParam = array_merge([APP_NAME, 'configs'], $ArrParam);
        $this->namespace = implode('\\', $ArrParam) ;
        $this->save();
    }

    private function save() :void
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
class " . $this->className . "
{
    public function set() : array
    {
        return [
        ];
    }
}
";
    }
}