<?php

function autoloadWeb($route)
{
    $existInclude = get_included_files();
    $appFunctionDir = APP . '/route/web';
    if (file_exists($appFunctionDir)) {
        $systemFnctionFiles = scandir($appFunctionDir);
        if (is_iterable($systemFnctionFiles)) {
            foreach ($systemFnctionFiles as $file) {
                if (!file_exists($appFunctionDir . '/' . $file)) {
                    continue;
                }
                if (in_array($appFunctionDir . '/' . $file, $existInclude)) {
                    continue;
                }
                $f = pathinfo($file);
                if ($f['extension'] == 'php') {
                    require $appFunctionDir . '/' . $file;
                }
            }
        }
    }
}