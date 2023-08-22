<?php

use system\core\database\database;
use system\core\request\request;
use system\core\lang\lang;
use system\core\user\auth;
use system\core\config\config;

if (!function_exists('db')) {
    function db()
    {
        return database::connect();
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
    function request($param = null)
    {
        if ($param) {
            return request::connect()->$param;
        } else {
            return request::connect();
        }
    }
}

if (!function_exists('includeFile')) {
    function includeFile($path)
    {
        try {
            if (file_exists($path)) {
                require $path;
            } else {
                throw new FileException('Файл ' . $path . ' не найден!');
            }
        } catch (FileException $e) {
            var_dump($e);
            exit($e->message);
        }
    }
}

if (!function_exists('createDir')) {
    function createDir($path)
    {
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }
    }
}

if (!function_exists('deleteDir')) {
	function deleteDir($path)
	{
		if (is_dir($path) === true) {
			$files = array_diff(scandir($path), array('.', '..'));
			foreach ($files as $file) {
				deleteDir(realpath($path) . '/' . $file);
			}
			return @rmdir($path);
		} else if (is_file($path) === true) {
			return unlink($path);
		}
		return false;
	}
}

if (!function_exists('copyDir')) {
	function copyDir($from, $to, $rewrite = true)
	{
		if (is_dir($from)) {
			@mkdir($to);
			$d = dir($from);
			while (false !== ($entry = $d->read())) {
				if ($entry == "." || $entry == "..")
					continue;
					copyDir($from . '/' . $entry, $to . '/' . $entry, $rewrite);
			}
			$d->close();
		} else {
			if (!file_exists($to) || $rewrite)
				copy($from, $to);
		}
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
            unset($_SESSION['history'][$lavel]['uri']);
            return $a;
        } else {
            return '/';
        }
    }
}

if (!function_exists('redirect')) {
    function redirect($url, $data = null, $error = null)
    {
        if ($data) {
            $_SESSION['data']  = $data;
        }

        if ($error) {
            $_SESSION['error']  = $error;
        }
        $url = empty($url) ? '/' : $url;
        header('Location: ' . $url);
        exit('header');
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
            foreach ($a as $b) {
                var_dump($b);
                exit();
            }
        }
    }
}

if (!function_exists('url')) {
    function url()
    {
        return $_SERVER['REQUEST_URI'];
    }
}

if (!function_exists('count_form')) {
    function count_form($name, $inc = false)
    {
        if ($inc) {
            $_SESSION['count_form'][$name] = $_SESSION['count_form'][$name] + 1;
            $_SESSION['count_form_date'][$name] = time();
        }
        return (int)$_SESSION['count_form'][$name];
    }
}

if (!function_exists('count_form_reset')) {
    function count_form_reset($name)
    {
        unset($_SESSION['count_form'][$name]);
    }
}
