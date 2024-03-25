<?php

use system\core\database\database;
use system\core\request\request;
use system\core\lang\lang;
use system\core\user\auth;
use system\core\config\config;
use system\core\files\files;
use system\core\system\header;

if (!function_exists('db')) {
    function db($configName = null)
    {
        return database::connect($configName);
    }
}

if (!function_exists('lang')) {
    function lang(string $fileName, string $lex, array $param = [])
    {
        $lang = lang::{$fileName}($lex);
        return $lang;
    }
}

if (!function_exists('config')) {
    function config(string $fileName, string $lex)
    {
        return config::{$fileName}($lex);
    }
}

if (!function_exists('user_id')) {
    function user_id()
    {
        return auth::status();
    }
}

if (!function_exists('request')) {
    function request($param = null, $val = null)
    {
        if ($param) {
            if ($val) {
                return request::connect()->$param->$val;
            } else {
                return request::connect()->$param;
            }
        } else {
            return request::connect();
        }
    }
}

if (!function_exists('includeFile')) {
    function includeFile($path)
    {
        files::includeFile($path);
    }
}

if (!function_exists('createDir')) {
    function createDir($path)
    {
        files::createDir($path);
    }
}

if (!function_exists('deleteDir')) {
    function deleteDir($path)
    {
        return files::deleteDir($path);
    }
}

if (!function_exists('copyDir')) {
    function copyDir($from, $to, $rewrite = true)
    {
        files::copyDir($from, $to, $rewrite);
    }
}

if (!function_exists('alert')) {
    function alert($text, $type = null)
    {
        $_SESSION['alert'][0] = $text;
        if ($type) {
            $_SESSION['alert'][] = $type;
        }
    }
}

if (!function_exists('alert2')) {
    function alert2($text, $type = 'primary', $header = '')
    {
        $_SESSION['alert2'][] = [
            'header' => $header,
            'text' => $text,
            'type' => $type,
        ];
    }
}

// function referal_url(){
//     $url = $_SERVER['HTTP_REFERER'];
//     $arrUrl = parse_url($url);
//     $query = empty($arrUrl['query']) ? '' : '?' . $arrUrl['query'];
//     $fragment = empty($arrUrl['fragment']) ? '' : '#' . $arrUrl['fragment'];
//     return  $arrUrl['path'] . $query . $fragment;
// }

if (!function_exists('referal_url')) {
    function referal_url($lavel = 1)
    {
        //$lavel = 0; Это текущая страница
        if (isset($_SESSION['history'][$lavel]['uri'])) {
            $a = $_SESSION['history'][$lavel]['uri'];
            unset($_SESSION['history'][$lavel]);
            return $a;
        } else {
            return '/';
        }
    }
}

if (!function_exists('redirect')) {
    function redirect($url, $data = null, $error = null)
    {
        (new header())->data($data)->error($error)->location($url);
    }
}

if (!function_exists('csrf')) {
    function csrf($name)
    {
        if (!isset($_SESSION['csrf'][$name])) {
            $token = bin2hex(random_bytes(35));
            $_SESSION['csrf'][$name] = $token;
            return  $token;
        } else {
            return $_SESSION['csrf'][$name];
        }
    }
}

if (!function_exists('returnModal')) {
    function returnModal($i)
    {
        $_SESSION['returnModal'] = $i;
    }
}

if (!function_exists('dump')) {
    function dump(...$a)
    {
        if (\system\core\config\config::globals('dev')) {
            if (\system\core\config\config::globals('dumpline')) {
                $backtrace = debug_backtrace();
                echo '<div style="font-size: 12px; padding:3px; background: #fff; font-family: monospace; white-space:nowrap;">
            <span style="color:#900;">' . $backtrace[0]['file'] . '</span>
            <span style="color:#090;">' . $backtrace[0]['line'] . '</span>
            </div>';
            }
            foreach ($a as $b) {
                var_dump($b);
            }
        }
    }
}

if (!function_exists('dd')) {
    function dd(...$a)
    {
        if (config::globals('dev')) {
            if (\system\core\config\config::globals('dumpline')) {
                $backtrace = debug_backtrace();
                echo '<div style="font-size: 12px; padding:3px; background: #fff; font-family: monospace; white-space:nowrap;">
                <span style="color:#900;">' . $backtrace[0]['file'] . '</span>
                <span style="color:#090;">' . $backtrace[0]['line'] . '</span>
                </div>';
            }
            foreach ($a as $b) {
                var_dump($b);
            }
            exit();
        }
    }
}

// if (!function_exists('url')) {
//     function url()
//     {
//         return $_SERVER['REQUEST_URI'];
//     }
// }

// if (!function_exists('count_form')) {
//     function count_form($name, $inc = false)
//     {
//         if ($inc) {
//             $_SESSION['count_form'][$name] = $_SESSION['count_form'][$name] + 1;
//             $_SESSION['count_form_date'][$name] = time();
//         }
//         return (int)$_SESSION['count_form'][$name];
//     }
// }

// if (!function_exists('count_form_reset')) {
//     function count_form_reset($name)
//     {
//         unset($_SESSION['count_form'][$name]);
//     }
// }
