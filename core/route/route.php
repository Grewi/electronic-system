<?php

namespace system\core\route;

use system\core\app\app;

class route
{
    protected $namespace = '';
    protected $get = true;
    protected $url = [];
    protected $groupName = null;
    protected $param_regex = '/[^a-zA-Zа-яА-Я0-9-_]/ui';
    protected $autoExitGroup = false;
    protected $autoExitController = true;

    public function __construct()
    {
        $app = app::app();
        if (ENTRANSE == 'web') {
            //Парсинг URL
            $urls = explode('?', $app->bootstrap->uri);
            $url = explode('/', $urls[0]);
            unset($url[0]);
            $this->url = $url;
            $app->request->set(['type' => 'web']);
            $app->request->set(['params' => $url]);
            request('global')->set(['url' => implode('/', $url)]);
        } elseif (ENTRANSE == 'console') {
            $argv = ARGV;
            unset($argv[0]);
            $this->url = $argv;
            $app->request->set(['type' => 'console']);
            $app->request->set(['params' => $argv]);
        }
    }

    public function group(string $name, callable $function): route
    {
        $name = $this->slash($name);
        if (is_null($this->get)) {
            $this->get = true;
        }

        if ($name[0] == '/') {
            $name = substr($name, 1);
        }

        $this->groupName = $name;
        $status = true;
        $nameArr = explode('/', $name);

        foreach ($nameArr as $a => $i) {
            if (@$this->url[$a + 1] != $i) {
                $status = false;
            }
        }

        if ($status && $this->get) {
            $function($this);
            if ($this->autoExitGroup) {
                exit();
            }
        } else {
            $this->get = false;
        }
        return $this;
    }

    public function namespace(string $namespace): route
    {
        $this->get = true;
        $namespace = str_replace('/', '\\', $namespace);
        $s = substr($namespace, -1);
        $s != '\\' ? $namespace = $namespace . '\\' : false;
        $this->namespace = $namespace;
        $this->groupName = null;
        return $this;
    }

    public function get(string $get = null): route
    {
        $get = $this->slash($get);
        if (is_null($get)) {
            return $this;
        }
        $this->parseUrl($get);
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $this->get = false;
        }
        return $this;
    }

    public function post(string $get): route
    {
        $get = $this->slash($get);
        $this->parseUrl($get);
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->get = false;
        }
        return $this;
    }

    public function put(string $get): route
    {
        $get = $this->slash($get);
        $this->parseUrl($get);
        if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
            $this->get = false;
        }
        return $this;
    }

    public function delete(string $get): route
    {
        $get = $this->slash($get);
        $this->parseUrl($get);
        if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
            $this->get = false;
        }
        return $this;
    }

    public function all(string $get): route
    {
        $get = $this->slash($get);
        $this->parseUrl($get);
        return $this;
    }

    public function console(string $get): route
    {

        if (isset($this->url[1]) && $get == $this->url[1]) {
            $this->get = true;
        } else {
            $this->get = false;
        }
        return $this;
    }

    public function permission(): route
    {
        return $this;
    }

    public function prefix($name): route
    {
        if ($this->get) {
            $class = '\\' . APP_NAME . '\\prefix\\' . $name;
            $get = (new $class)->index();
            if (!is_null($get)) {
                $this->get = $get;
            }
        }
        return $this;
    }

    public function filter($name)
    {
        $class = '\\' . APP_NAME . '\\filter\\' . $name;
        (new $class)->index();
    }

    public function controller($class, $method): route
    {
        if ($this->get) {
            $controller = $this->namespace . $class;
            $_SERVER['routeController'] = $controller;
            (new $controller)->$method();
            if ($this->autoExitController) {
                exit();
            }
        }
        return $this;
    }

    public function exit(): void
    {
        if ($this->get) {
            exit();
        }
        $this->get = true;
    }

    private function parseUrl(string $get): void
    {
        $app = app::app();
        if ($this->groupName) {
            if ($get == '/') {
                $get = substr($get, 1);
            }
            $get = '/' . $this->groupName . $get;
        }

        //Парсинг $get
        $g = explode('/', $get);
        unset($g[0]);

        $url = (array) $this->url;
        $check = true;

        //Если длина url меньше роута без необязательных параметров
        $gg = $this->delParametr($g);
        if (count($url) < count($gg)) {
            $check = false;
        }

        foreach ($url as $a => $i) {

            //Если на последней итерации пусто. пропускаем
            if (empty($i) && count($url) == $a) {
                if ($i != @$g[$a]) {
                    $check = false;
                }
                continue;
            }

            if (isset($g[$a])) {
                preg_match('/\{(.*?)\}/si', $g[$a], $param);
                preg_match('/\{(.*?)\?\}/si', $g[$a], $freeParam);

                //Если сработал необязательный параметр, удаляем обязательный
                if (isset($freeParam[1])) {
                    unset($param);
                }

                //Проверка не обязательного параметра
                if (isset($freeParam[1])) {
                    $getReturn = preg_replace($this->param_regex, '', urldecode($url[$a]));
                    $app->getparams->set([$freeParam[1] => $getReturn]);
                    request('get')->set([$freeParam[1] => $getReturn]);
                    continue;
                }

                //Проверка обязательного параметра
                if (!empty($param) && empty($url[$a])) {
                    $check = false;
                    break;
                } elseif ((isset($param[1]) && !empty($url[$a])) && $check) {
                    $getReturn = preg_replace($this->param_regex, '', urldecode($url[$a]));
                    $app->getparams->set([$param[1] => $getReturn]);
                    request('get')->set([$param[1] => $getReturn]);
                }

                //Проверка элемента url
                if ($url[$a] != $g[$a] && !isset($param[1]) && !isset($freeParam[1])) {
                    $check = false;
                    break;
                }
            } else {

                $check = false;
            }
        }

        $this->get = $check;
    }

    public function getUrl()
    {
        return $this->url;
    }

    private function delParametr(array $param)
    {
        preg_match('/\{(.*?)\?\}/si', $param[count($param)], $freeParam);
        if (isset($freeParam[0])) {
            unset($param[count($param)]);
            return $this->delParametr($param);
        } else {
            return $param;
        }
    }

    public function autoExitGroup($status)
    {
        $this->autoExitGroup = $status;
    }

    public function autoExitController($status)
    {
        $this->autoExitController = $status;
    }

    public function autoloadWeb()
    {
        $existInclude = get_included_files();
        $appFunctionDir = APP . '/route/web';
        $generatorPage = null;
        $route = $this;
        if (file_exists($appFunctionDir)) {
            $systemFnctionFiles = scandir($appFunctionDir);
            asort($systemFnctionFiles);
            if (is_iterable($systemFnctionFiles)) {
                foreach ($systemFnctionFiles as $file) {
                    if (!file_exists($appFunctionDir . '/' . $file)) {
                        continue;
                    }
                    if (in_array($appFunctionDir . '/' . $file, $existInclude)) {
                        continue;
                    }
                    if ($file == 'generatorPage.php') {
                        $generatorPage = $appFunctionDir . '/' . $file;
                        continue;
                    }

                    $f = pathinfo($file);
                    if ($f['extension'] == 'php') {
                        require $appFunctionDir . '/' . $file;
                    }
                }
            }
            if ($generatorPage) {
                require $generatorPage;
            }
        }
    }

    private function slash($str)
    {
        if($str){
            $str = str_replace('\\', '/', $str);
            return '/' . trim($str, '/');            
        }
    }
}
