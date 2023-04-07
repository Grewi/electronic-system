<?php

$systemFunctionDir = SYSTEM . '/function';
if (file_exists($systemFunctionDir)) {
    $systemFnctionFiles = scandir($systemFunctionDir);
    if (is_iterable($systemFnctionFiles)) {
        foreach ($systemFnctionFiles as $file) {
            if (!file_exists($systemFunctionDir . '/' . $file)) {
                continue;
            }
            $f = pathinfo($file);
            if ($f['extension'] == 'php') {
                require $systemFunctionDir . '/' . $file;
            }
        }
    }
}

$appFunctionDir = APP . '/system/function';
if (file_exists($appFunctionDir)) {
    $systemFnctionFiles = scandir($appFunctionDir);
    if (is_iterable($systemFnctionFiles)) {
        foreach ($systemFnctionFiles as $file) {
            if (!file_exists($appFunctionDir . '/' . $file)) {
                continue;
            }
            $f = pathinfo($file);
            if ($f['extension'] == 'php') {
                require $appFunctionDir . '/' . $file;
            }
        }
    }
}
