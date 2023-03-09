<?php 

namespace system\console;

class createController
{
    private $parametr;
    private $className;
    private $path;
    private $path_v;
    private $pathDir;
    private $path_crud_v = [];
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
        $this->namespace = implode('\\', $_ArrParam);

        if(!$v){
            exit('0');
            $this->saveController();
        }
        

        if($v == 'v'){
            $this->path_v = ROOT . '/app/views/' . $parametr . '.php';
            $this->pathDir_v = ROOT . '/app/views/' . implode('/', $ArrParam);
            $this->saveController();
            $this->save_v();
        }

        if($v == 'crud'){
            $this->pathDir_v = ROOT . '/app/views/' . $parametr;
            $this->path_crud_v[] = ROOT . '/app/views/' . $parametr . '/index.php';
            $this->path_crud_v[] = ROOT . '/app/views/' . $parametr . '/create.php';
            $this->path_crud_v[] = ROOT . '/app/views/' . $parametr . '/update.php';
            $this->path_crud_v[] = ROOT . '/app/views/' . $parametr . '/delete.php';
            $this->crud();
        }
    }

    private function saveController()
    {
        if(!file_exists($this->path)){

            if(!file_exists($this->pathDir)){
                mkdir($this->pathDir, 0755, true);
            }
            $layout = "<?php 
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
            file_put_contents($this->path, $layout);
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



    private function crud()
    {
        // Генерируем шаблоны
        foreach($this->path_crud_v as $i){
            if(!file_exists($i)){

                if(!file_exists($this->pathDir_v)){
                    mkdir($this->pathDir_v, 0755, true);
                }
                file_put_contents($i, '');
            }            
        }

        //создаём контроллер
        if(!file_exists($this->path)){

            if(!file_exists($this->pathDir)){
                mkdir($this->pathDir, 0755, true);
            }
            $layout = "<?php 
            namespace " . $this->namespace . ";
            use app\controllers\controller;
            use system\core\\view\\view;
            
            class " . $this->className . " extends controller
            {
                public function index()
                {
                    \$this->title('');
                    new view('" . $this->parametr . "/index', \$this->data);
                }

                public function create()
                {
                    \$this->title('');
                    new view('" . $this->parametr . "/create', \$this->data);
                }

                public function update()
                {
                    \$this->title('');
                    new view('" . $this->parametr . "/update', \$this->data);
                }

                public function delete()
                {
                    \$this->title('');
                    new view('" . $this->parametr . "/delete', \$this->data);
                }
            }
            ";
            file_put_contents($this->path, $layout);
        }
    }
}