<?php

if (!function_exists('eSanitizerLatInt')) {
    function eSanitizerLatInt($str)
    {
        return preg_replace('/[^a-zA-Z0-9]/ui', '', $str);
    }
}

if (!function_exists('eSanitizerLatRuInt')) {
    function eSanitizerLatRuInt($str)
    {
        return preg_replace('/[^a-zA-Zа-яА-Я0-9]/ui', '', $str);
    }
}

if (!function_exists('eSanitizerFloat')) {
    function eSanitizerFloat($str)
    {
        return preg_replace('/[^0-9.,]/ui', '', $str);
    }
}

if (!function_exists('eSanitizerInt')) {
    function eSanitizerInt($str)
    {
        return preg_replace('/[^0-9]/ui', '', $str);
    }
}

if (!function_exists('eSanitizerDate')) {
    function eSanitizerDate($str)
    {
        return preg_replace('/[^0-9-]/ui', '', $str);
    }
}

if (!function_exists('eSanitizerDate')) {
    function eSanitizerDEmail($str)
    {
        return preg_replace('/[^@.a-zA-Zа-яА-Я0-9-_]/ui', '', $str);
    }
}
