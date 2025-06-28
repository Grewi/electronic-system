<?php

namespace system\console;

class createController
{
    private $parametr;
    private $ArrParam;
    private $className;
    private $path;
    private $path_v;
    private $pathDir;
    private $pathDir_v;
    private $route;
    private $path_crud_v = [];
    private $namespace;



    public function index()
    {
        if(!isset(ARGV[2])){
            echo 'Не указан обязательный параметр' . PHP_EOL;
            exit();
        }
        $parametr = ARGV[2];
        $this->parametr = $parametr;

        $this->ArrParam = $ArrParam = explode('/', $parametr);
        $this->className = array_pop($ArrParam) . 'Controller';
        $this->path    = APP . '/controllers/' . $parametr . 'Controller.php';
        $this->pathDir = APP . '/controllers/' . implode('/', $ArrParam);
        $this->route   = APP . '/route/web/00_' . str_replace('/', '_', $parametr) . '.php';
        $_ArrParam     = array_merge([APP_NAME, 'controllers'], $ArrParam);
        $this->namespace = implode('\\', $_ArrParam);
        $v = null;
        if (!isset(ARGV[3])) {
            $this->saveController();
        }else{
            $v = ARGV[3];
        }

        if ($v == 'v') {
            $this->path_v = APP . '/views/' . $parametr . '.php';
            $this->pathDir_v = APP . '/views/' . implode('/', $ArrParam);
            $this->saveController();
            $this->save_v();
        }

        if ($v == 'crud') {
            $this->pathDir_v = APP . '/views/' . $parametr;
            $this->path_crud_v[] = APP . '/views/' . $parametr . '/index.php';
            $this->path_crud_v[] = APP . '/views/' . $parametr . '/create.php';
            $this->path_crud_v[] = APP . '/views/' . $parametr . '/update.php';
            $this->path_crud_v[] = APP . '/views/' . $parametr . '/delete.php';
            $this->crud();
        }

        if ($v == 'full') {

            $this->full($parametr);
        }
    }

    private function saveController()
    {
        if (!file_exists($this->path)) {

            if (!file_exists($this->pathDir)) {
                mkdir($this->pathDir, 0755, true);
            }
            $layout = "<?php 
namespace " . $this->slRev($this->namespace) . ";
use " . $this->slRev(APP_NAMESPACE) . "\controllers\controller;
use electronic\core\\view\\view;

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
        if (!file_exists($this->path_v)) {

            if (!file_exists($this->pathDir_v)) {
                mkdir($this->pathDir_v, 0755, true);
            }
            file_put_contents($this->path_v, '');
        }
    }



    private function crud()
    {
        // Генерируем шаблоны
        foreach ($this->path_crud_v as $i) {
            if (!file_exists($i)) {

                if (!file_exists($this->pathDir_v)) {
                    mkdir($this->pathDir_v, 0755, true);
                }
                file_put_contents($i, '');
            }
        }

        //создаём контроллер
        if (!file_exists($this->path)) {

            if (!file_exists($this->pathDir)) {
                mkdir($this->pathDir, 0755, true);
            }
            $layout = "<?php 
namespace " . $this->slRev($this->namespace) . ";
use " . $this->slRev(APP_NAMESPACE) . "\controllers\controller;
use electronic\core\\view\\view;

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

    private function full($parametr)
    {
        $this->pathDir_v = APP . '/views/' . $parametr;
        $this->path_crud_v[] = APP . '/views/' . $parametr . '/index.php';
        $this->path_crud_v[] = APP . '/views/' . $parametr . '/create.php';
        $this->path_crud_v[] = APP . '/views/' . $parametr . '/update.php';
        $this->path_crud_v[] = APP . '/views/' . $parametr . '/delete.php';

        // Генерируем шаблоны
        foreach ($this->path_crud_v as $i) {
            if (!file_exists($i)) {

                if (!file_exists($this->pathDir_v)) {
                    mkdir($this->pathDir_v, 0755, true);
                }
                file_put_contents($i, '<use layout="index" />

<block name="index"></block>');

                //создаём контроллер
                if (!file_exists($this->path)) {

                    if (!file_exists($this->pathDir)) {
                        mkdir($this->pathDir, 0755, true);
                    }
                    $layout = "<?php 
namespace " . $this->slRev($this->namespace) . ";
use " . $this->slRev(APP_NAMESPACE) . "\controllers\controller;
use electronic\core\\view\\view;
use electronic\core\\validate\\validate;

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

    public function createAction()
    {
        \$valid = new validate();
        \$valid->name('csrf')->csrf('');

        if(!\$valid->control()){
            alert('Ошибка сохранения', 'danger');
            redirect(referal_url(), \$valid->data(), \$valid->error());
        }

        //

        alert('Успешно', 'success');
        redirect(referal_url());
    }    

    public function update()
    {
        \$this->title('');
        new view('" . $this->parametr . "/update', \$this->data);
    }

    public function updateAction()
    {
        \$valid = new validate();
        \$valid->name('csrf')->csrf('');

        if(!\$valid->control()){
            alert('Ошибка сохранения', 'danger');
            redirect(referal_url(), \$valid->data(), \$valid->error());
        }

        //

        alert('Успешно', 'success');
        redirect(referal_url());
    }     

    public function delete()
    {
        \$this->title('');
        new view('" . $this->parametr . "/delete', \$this->data);
    }

    public function deleteAction()
    {
        \$valid = new validate();
        \$valid->name('csrf')->csrf('');

        if(!\$valid->control()){
            alert('Ошибка сохранения', 'danger');
            redirect(referal_url(), \$valid->data(), \$valid->error());
        }

        //

        alert('Успешно', 'success');
        redirect(referal_url());
    } 
}
";
                    file_put_contents($this->path, $layout);
                }

                if($this->route){
                    $arrParam = $this->ArrParam;
                    $lastEl = array_pop($arrParam);
                    $chiftEl = array_shift($arrParam);
                    $r = count($arrParam) > 0 ?  '/' . implode('/', $arrParam) : '';
                //Создаём роут
                $layout = "<?php 
                \$route->namespace('" . $this->sl($this->namespace) . "')->group('/" . $chiftEl . "', function(\$route){
                    \$route->get('" . $r . "/')->controller('" . $lastEl . "Controller', 'index');
                    \$route->get('" . $r . "/create')->controller('" . $lastEl . "Controller', 'create');
                    \$route->post('" . $r . "/create')->controller('" . $lastEl . "Controller', 'createAction');
                    \$route->get('" . $r . "/edit/{param_id}')->controller('" . $lastEl . "Controller', 'update');
                    \$route->post('" . $r . "/edit/{param_id}')->controller('" . $lastEl . "Controller', 'updateAction');
                    \$route->get('" . $r . "/delete/{param_id}')->controller('" . $lastEl . "Controller', 'delete');
                    \$route->post('" . $r . "/delete/{param_id}')->controller('" . $lastEl . "Controller', 'deleteAction');
                });";
                file_put_contents($this->route, $layout);                    
                }

            }
        }
    }

    private function slRev(string $a) : string
    {
        return str_replace('/', '\\', $a);
    }

    private function sl(string $a) : string
    {
        return str_replace('\\', '/', $a);
    }
}
