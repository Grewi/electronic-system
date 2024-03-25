<?php

use system\core\app\app;

!INDEX ? exit('exit') : true;
if (ENTRANSE == 'web') {
    $app = app::app();
    $uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
    $url = (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == 'off' ? 'http' : 'https') . '://' . $_SERVER['HTTP_HOST'];
    $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
    $method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : '';

    request('global')->set(['uri' => $uri]);
    $app->bootstrap->set(['uri' => $uri]);
    $app->bootstrap->set(['url' => $url]);
    $app->bootstrap->set(['host' => $host]);
    $app->bootstrap->set(['method' => $method]);

    if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)) {
        $ip = @$_SERVER['HTTP_CLIENT_IP'];
    } elseif (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
        $ip = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = @$_SERVER['REMOTE_ADDR'];
    }
    $app->bootstrap->set(['ip' => $ip]);
    request('global')->set(['ip' => $ip]);


    if (isset($_SERVER['HTTP_USER_AGENT']) and $_SERVER['HTTP_USER_AGENT'] != '-') {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        request('global')->set(['user_agent' => $user_agent]);
        $app->bootstrap->set(['user_agent' => $user_agent]);
    }

    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        request('global')->set(['ajax' => true]);
        $app->bootstrap->set(['ajax' => true]);
    } else {
        $app->bootstrap->set(['ajax' => false]);
    }



    if (!request('global')->ajax && isset($_SERVER['REQUEST_URI'])) {

        if (empty($_SESSION['history'])) {
            $_SESSION['history'][] = [
                'uri'    => $_SERVER['REQUEST_URI'],
                'method' => $_SERVER['REQUEST_METHOD']
            ];
        }

        $oldUri    = isset($_SESSION['history'][0]['uri'])    ? $_SESSION['history'][0]['uri']    : null;
        $oldMethod = isset($_SESSION['history'][0]['method']) ? $_SESSION['history'][0]['method'] : null;

        if (($oldUri && $oldUri != $_SERVER['REQUEST_URI']) || ($oldMethod && $oldMethod != $_SERVER['REQUEST_METHOD'])) {
            array_unshift($_SESSION['history'], [
                'uri'    => $_SERVER['REQUEST_URI'],
                'method' => $_SERVER['REQUEST_METHOD']
            ]);
        }
    }
    unset($ip, $uri, $url, $host, $user_agent, $method);
}
