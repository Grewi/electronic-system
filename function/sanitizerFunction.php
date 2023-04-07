<?php

function eSanitizerLatInt($str){
    return preg_replace('/[^a-zA-Z0-9]/ui', '', $str);
}

function eSanitizerLatRuInt($str){
    return preg_replace('/[^a-zA-Zа-яА-Я0-9]/ui', '', $str);
}

function eSanitizerFloat($str){
    return preg_replace('/[^0-9.,]/ui', '', $str);
}

function eSanitizerInt($str){
    return preg_replace('/[^0-9]/ui', '', $str);
} 

function eSanitizerDate($str){
    return preg_replace('/[^0-9-]/ui', '', $str);
} 

function eSanitizerDEmail($str){
    return preg_replace('/[^@.a-zA-Zа-яА-Я0-9-_]/ui', '', $str);
} 