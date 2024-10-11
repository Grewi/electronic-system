<?php
use system\core\text\sanitizer;

if (!function_exists('eSanitizerLatInt')) {
    function eSanitizerLatInt($str)
    {
        return sanitizer::latInt($str);
    }
}

if (!function_exists('eSanitizerLatRuInt')) {
    function eSanitizerLatRuInt($str)
    {
        return sanitizer::latRuInt($str);
    }
}

if (!function_exists('eSanitizerFloat')) {
    function eSanitizerFloat($str)
    {
        return sanitizer::float($str);
    }
}

if (!function_exists('eSanitizerInt')) {
    function eSanitizerInt($str)
    {
        return sanitizer::int($str);
    }
}

if (!function_exists('eSanitizerDate')) {
    function eSanitizerDate($str)
    {
        return sanitizer::date($str);
    }
}

if (!function_exists('eSanitizerDate')) {
    function eSanitizerDEmail($str)
    {
        return sanitizer::email($str);
    }
}
