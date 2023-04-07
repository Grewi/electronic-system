<?php 
!INDEX ? exit('exit') : true;

request('global')->set(['uri' => isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '']);

if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)) {
    $ip = @$_SERVER['HTTP_CLIENT_IP'];
} elseif (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
    $ip = @$_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = @$_SERVER['REMOTE_ADDR'];
}

request('global')->set(['ip' => $ip]);
unset($ip);

if (isset($_SERVER['HTTP_USER_AGENT']) AND $_SERVER['HTTP_USER_AGENT'] != '-')
{
    request('global')->set(['user_agent' => $_SERVER['HTTP_USER_AGENT']]);
}

