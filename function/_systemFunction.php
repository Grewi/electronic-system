<?php
use system\core\database\database;
use system\core\request\request;
use system\core\lang\lang;
use system\core\user\login;
use system\core\config\config;

function db()
{
    return database::connect();
}

function lang( string $fileName, string $lex, array $param = [])
{
    $lang = lang::connect();
    return $lang->return($fileName, $lex, $param);
}

function user_id()
{
    return (login::connect())->status();
}

function request($param = null)
{
    if($param){
        return request::connect()->$param;
    }else{
        return request::connect();
    }
    
}

function includeFile($path)
{
    try{
        if(file_exists($path)){
            require $path;
        }else{
            throw new FileException('Файл ' . $path . ' не найден!');
        }        
    }catch(FileException $e){
        exit($e->message);
    }

}

function alert($text, $type = null)
{
    $_SESSION['alert'][0] = $text;
    if($type){
        $_SESSION['alert'][] = $type;
    }
}

function alert2($text, $type = 'primary', $header = '')
{
    $_SESSION['alert2'][] = [
        'header' => $header,
        'text' => $text, 
        'type' => $type,
    ];
}

function referal_url(){
    $url = $_SERVER['HTTP_REFERER'];
    $arrUrl = parse_url($url);
    $query = empty($arrUrl['query']) ? '' : '?' . $arrUrl['query'];
    $fragment = empty($arrUrl['fragment']) ? '' : '#' . $arrUrl['fragment'];
    return  $arrUrl['path'] . $query . $fragment;
}

function redirect($url, $data = null, $error = null)
{
    if($data){
        $_SESSION['data']  = $data;
    }
    
    if($error){
        $_SESSION['error']  = $error;
    }
    $url = empty($url) ? '/' : $url;
    header('Location: ' . $url);
    exit('header');
}

function csrf($name)
{
    $token = bin2hex(random_bytes(35));
    $_SESSION['csrf'][$name] = $token;
    return  $token;
}

function returnModal($i)
{
    $_SESSION['returnModal'] = $i;
}

function dump(...$a)
{
    if(\system\core\config\config::globals('dev')){
        foreach($a as $b){
            var_dump($b);
        }
    }
}

function dd(...$a)
{
    if(config::globals('dev')){
        foreach($a as $b){
            var_dump($b);
            exit();
        }
    }
    
}

function url()
{
    return $_SERVER['REQUEST_URI'];
}

function count_form($name, $inc = false)
{
    if($inc){
        $_SESSION['count_form'][$name] = $_SESSION['count_form'][$name] +1;
        $_SESSION['count_form_date'][$name] = time();
    }
   return (int)$_SESSION['count_form'][$name];
}

function count_form_reset($name){
    unset($_SESSION['count_form'][$name]);
}