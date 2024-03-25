<?php

namespace system\core\history;

class history
{

    public static function unshift()
    {
        $oldUri = $_SESSION['history'][0]['uri'];
        $oldMethod = $_SESSION['history'][0]['method'];
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];
        $data = [
            'uri' => $uri,
            'method' => $method,
        ];

        if(!isset($_SESSION['history'])){
            $_SESSION['history'] = [];
        }

        if ($oldUri != $uri) {
            array_unshift($_SESSION['history'], $data);
        } else {
            if ($oldMethod != $method) {
                array_unshift($_SESSION['history'], $data);
            }
        }
    }


    public static function shift()
    {
        array_shift($_SESSION['history']);
    }
}
