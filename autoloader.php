<?php declare(strict_types=1);
!INDEX ? exit('exit') : true;

function systemAutoLoader(string $className) {
    $autoloader = new autoloader();
    $autoloader->start($className);
}
spl_autoload_register('systemAutoLoader');

class autoloader
{
    private $namespace  = '';
    private $classArray = [];
    private $pathSystem = '';
    private $pathApp = '';

    public function start($namespace)
    {
        $this->namespace = str_replace('\\', '/', $namespace);
        $this->classArray = explode('/', $this->namespace);
        
        if($this->classArray[0] == 'electronic'){
            $this->system();
        }else{
            includeFile(ROOT . '/' . $namespace . '.php');
        }
    }

    private function system()
    {
        $path = $this->classArray;
        unset($path[0]);
        $this->pathApp = '/app/system/' . implode('/', $path);
        $this->pathSystem = '/system/' . implode('/', $path);

        if(file_exists(ROOT . $this->pathSystem . '.php')){
            if(!file_exists(ROOT . $this->pathApp . '.php')){
                $this->createFile(ROOT . $this->pathApp);
            }
            includeFile(ROOT . $this->pathApp . '.php');
        }
    }

    private function createFile()
    {
        $path = $this->classArray;
        $className = $path[count($path) - 1];
        unset($path[0]);
        unset($path[count($path) - 1]);
        $p = ROOT . '/app/system/' . implode('/', $path);
        createDir($p);

        $namespace = $this->classArray;
        unset($namespace[0]);
        unset($namespace[count($namespace) - 1]);
        $n = 'electronic/' . implode('/', $namespace);
        // $namspace = implode() $this->namespace
        
        $class = '<?php
namespace ' . str_replace('/', '\\', $n) . ';
class ' . $className .' extends ' . str_replace('/', '\\', $this->pathSystem) . '
{

}
';
        file_put_contents(ROOT . $this->pathApp . '.php', $class);
    }
}