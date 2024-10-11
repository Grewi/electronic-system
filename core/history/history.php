<?php

namespace system\core\history;
use system\core\app\app;

class history
{

    /**
     * Добавить запись в историю
     */
    public static function unshift()
    {
        $app = app::app();
        if (!$app->bootstrap->ajax && isset($_SERVER['REQUEST_URI'])) {
            
            if (empty($_SESSION['history'])) {
                $_SESSION['history'][] = [
                    'uri'    => $_SERVER['REQUEST_URI'],
                    'method' => $_SERVER['REQUEST_METHOD'],
                    'id' => md5(date('U')),
                ];
            }
    
            $oldUri    = isset($_SESSION['history'][0]['uri'])    ? $_SESSION['history'][0]['uri']    : null;
            $oldMethod = isset($_SESSION['history'][0]['method']) ? $_SESSION['history'][0]['method'] : null;
    
            if (($oldUri && $oldUri != $_SERVER['REQUEST_URI']) || ($oldMethod && $oldMethod != $_SERVER['REQUEST_METHOD'])) {

                array_unshift($_SESSION['history'], [
                    'uri'    => $_SERVER['REQUEST_URI'],
                    'method' => $_SERVER['REQUEST_METHOD'],
                    'id' => md5(date('U')),
                ]);
            }
        }
        $app->history->set($_SESSION['history']);
    }

    /**
     * Удалить последнюю запись из истории
     */
    public static function shift()
    {
        $app = app::app();
        array_shift($_SESSION['history']);
        $app->history->set($_SESSION['history']);
    }

    /**
     * Возвращает текущий id
     */
    public static function currentId()
    {
        if(isset($_SESSION['history'][0]['id'])){
            return $_SESSION['history'][0]['id'];
        }
    }

    /**
     * Ищет номер записи по id
     */
    public static function find($id){
        foreach($_SESSION['history'] as $a => $i){
            if(isset($i['id']) && $i['id'] == $id){
                return $a;
            }
        }
    }

    public static function referal()
    {
        $s = null;
        if(isset($_REQUEST['historyid'])){
            $s = self::find($_REQUEST['historyid']);
        }
        $s = $s ? $s : 0;
        if(isset($_SESSION['history'])){
            foreach($_SESSION['history'] as $a => $i){
                if($a < $s || $i['method'] != 'GET'){
                    continue;
                }
                if($_SERVER['REQUEST_URI'] == $i['uri']){
                    continue;
                }
                return $i['uri'];
            }
        }
        return '/';
    }
}
