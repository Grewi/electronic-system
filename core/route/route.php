<?php
namespace system\core\route;

class route
{
    protected $namespace = '';
    protected $get = true;
    protected $url = [];
    protected $groupName = null;
    protected $param_regex = '/[^a-zA-Zа-яА-Я0-9-_]/ui';
    
    public function __construct()
    {
        if(ENTRANSE == 'web'){
            //Парсинг URL
            $urls = explode('?', request('global')->uri);
            $url = explode('/', $urls[0]);
            unset($url[0]);
            $this->url = $url;
        }elseif(ENTRANSE == 'console') {
            $argv = ARGV;
            unset($argv[0]);
            $this->url = $argv;
        }
    }

    public function group( string $name, callable $function) : route
    {
        if($name[0] == '/'){
            $name = substr($name, 1);
        }

        $this->groupName = $name;
        $status = true;
        foreach(explode('/', $name) as $a => $i){
            if($this->url[$a + 1] != $i){
                $status = false;
            }
        }
        $offset = stripos(implode('/', $this->url), $this->groupName);

        if($status){
            $function($this);
        }else{
            $this->get = false;
        }
        return $this;
    }

    public function namespace( string $namespace) : route
    {
        $namespace = str_replace('/', '\\', $namespace);
        $s = substr($namespace, -1);
        $s != '\\' ? $namespace = $namespace . '\\' : false;
        $this->namespace = $namespace;
        $this->groupName = null;
        return $this;
    }
    
    public function get( string $get) : route
    {
        $this->parseUrl($get);
        if($_SERVER['REQUEST_METHOD'] !== 'GET'){
            $this->get = false;
        }
        return $this;
    } 
    
    public function post( string $get) : route
    {
        $this->parseUrl($get);
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            $this->get = false;
        }
        return $this;
    }

    public function put( string $get) : route
    {
        $this->parseUrl($get);
        if($_SERVER['REQUEST_METHOD'] !== 'PUT'){
            $this->get = false;
        }
        return $this;
    } 
    
    public function delete( string $get) : route
    {
        $this->parseUrl($get);
        if($_SERVER['REQUEST_METHOD'] !== 'DELETE'){
            $this->get = false;
        }
        return $this;
    }

    public function all( string $get) : route
    {
        $this->parseUrl($get);
        return $this;
    }    

    public function console( string $get) : route
    {
        if($get == $this->url[1]){
            $this->get = true;
        }else{
            $this->get = false;
        }
        return $this;
    }     

    public function permission() :route
    {
        return $this;
    }

    public function prefix($name) : route
    {
        if($this->get){
            $class = '\\' . APP_NAME . '\\prefix\\'. $name;
            $get = (new $class)->index();
            if(!is_null($get)){
                $this->get = $get;
            }
        }
        return $this;
    }

    public function filter($name)
    {
        $class = '\\' . APP_NAME . '\\filter\\'. $name;
        (new $class)->index();
    }

    public function controller($class, $method) : route
    {
        if($this->get){
            $controller = $this->namespace . $class;
            $_SERVER['routeController'] = $controller;
            (new $controller)->$method();
        }
        return $this;
    }

    public function exit() : void
    {
        if($this->get){
            exit();
        }
        $this->get = true;
    }

    private function parseUrl( string $get) : void
    {  
        if($this->groupName){
            if($get == '/'){
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
        if(count($url) < count($gg)){
            $check = false;
        }

        foreach($url as $a => $i){

            //Если на последней итерации пусто. пропускаем
            if(empty($i) && count($url) == $a){
                continue;
            }

            if(isset($g[$a])){
                preg_match('/\{(.*?)\}/si', $g[$a], $param);
                preg_match('/\{(.*?)\?\}/si', $g[$a], $freeParam);

                //Если сработал необязательный параметр, удаляем обязательный
                if($freeParam[1]){
                    unset($param);
                }

                //Проверка не обязательного параметра
                if(isset($freeParam[1])){
                    request('get')->set([$freeParam[1] => preg_replace($this->param_regex, '', urldecode($url[$a])) ]);
                    continue;
                }

                //Проверка обязательного параметра
                if(!empty($param) && empty($url[$a])){
                    $check = false;
                    break;

                }elseif( ( isset($param[1]) && !empty($url[$a]) ) && $check){
                    request('get')->set([$param[1] => preg_replace($this->param_regex, '', urldecode($url[$a])) ]);
                }

                //Проверка элемента url
                if( $url[$a] != $g[$a] && !isset($param[1]) && !isset($freeParam[1])){
                    $check = false;
                    break;
                }
                
            }else{
                
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
        if(isset($freeParam[0])){
            unset($param[count($param)]);
            return $this->delParametr($param);
        }else{
            return $param;
        }
    }
}