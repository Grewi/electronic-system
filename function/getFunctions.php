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

        $query = $a['query'] ?? '';
        $fragment = $a['fragment'] ?? false;
        $path = $a['path'] ?? '';

        parse_str($query, $get);

        if ($value) {
            $get[$name] = $value;
        } else {
            unset($get[$name]);
        }

        $get = $get ? '?' . http_build_query($get, '', '&') : '';
        $f = $fragment ? '#' . $fragment : '';
        return $path . $get  . $f;
    }
}
