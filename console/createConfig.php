<?php 

namespace system\console;

class createConfig
{
    public function index()
    {
        $parametr = ARGV[2];
        $ArrParam = explode('/', $parametr);
        $this->className = array_pop($ArrParam);
        $this->path = ROOT . '/app/configs/' . $parametr . '.php';
        $this->pathDir = ROOT . '/app/configs/' . implode('/', $ArrParam) ;
        $ArrParam = array_merge(['app', 'configs'], $ArrParam);
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