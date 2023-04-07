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

    public function start(string $namespace) : void
    {
        $this->namespace = str_replace('\\', '/', $namespace);
        $this->classArray = explode('/', $this->namespace);
        
        if($this->classArray[0] == 'electronic'){
            $this->system();
        }else{
            includeFile(ROOT . '/' . $this->namespace . '.php');
        }
    }

    private function system() : void
    {
        $path = $this->classArray;
        unset($path[0]);
        $this->pathApp = '/' . APP_NAME . '/system/' . implode('/', $path);
        $this->pathSystem = '/system/' . implode('/', $path);

        if(file_exists(ROOT . $this->pathSystem . '.php')){
            if(!file_exists(ROOT . $this->pathApp . '.php')){
                $this->createFile(ROOT . $this->pathApp);
            }
            includeFile(ROOT . $this->pathApp . '.php');
        }

        if(!file_exists(ROOT . $this->pathSystem . '.php') && file_exists(ROOT . $this->pathApp . '.php')){
            includeFile(ROOT . $this->pathApp . '.php');
        }
    }

    private function createFile() : void
    {
        $path = $this->classArray;
        $className = $path[count($path) - 1];
        unset($path[0]);
        unset($path[count($path)]);
        $p = ROOT . '/app/system/' . implode('/', $path);
        createDir($p);

        $namespace = $this->classArray;
        unset($namespace[0]);
        unset($namespace[count($namespace)]);
        $n = 'electronic/' . implode('/', $namespace);
        
        $class = '<?php
namespace ' . str_replace('/', '\\', $n) . ';
class ' . $className .' extends ' . str_replace('/', '\\', $this->pathSystem) . '
{

}
';
        file_put_contents(ROOT . $this->pathApp . '.php', $class);
    }
}