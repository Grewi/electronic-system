<?php

//Меняет значение Get параметра
if (!function_exists('eGetReplace')) {
    function eGetReplace($name, $value = null, $request = null)
    {
        if ($request) {
            $a = parse_url($request);
        } else {
            $a = parse_url($_SERVER['REQUEST_URI']);
        }

        parse_str($a['query'], $get);

        if ($value) {
            $get[$name] = $value;
        } else {
            unset($get[$name]);
        }


        $get = $get ? '?' . http_build_query($get, '', '&') : '';
        $fragment = $a['fragment'] ? '#' . $a['fragment'] : '';
        return $a['path'] . $get  . $fragment;
    }
}
