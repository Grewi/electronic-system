<?php

use system\core\config\config;
use system\core\files\files;

if (file_exists(APP . '/configs/errors.php')) {

    $iniFile = APP . '/configs/.errors.ini';
    $errors = config::errors();
    $errorCacheDir = APP . '/cache';
    $errorCacheFile = $errorCacheDir . '/errorCacheFile.php';
    $ERROR_INI_MB5 = null;

    if ($errors->display == 1) {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
    } else {
        ini_set('display_errors', 0);
        ini_set('display_startup_errors', 0);
    }
    if (file_exists($iniFile)) {
        $mb5 = md5_file($iniFile);
    }


    if (file_exists($errorCacheFile)) {
        
        require $errorCacheFile;
        if($mb5 != $ERROR_INI_MB5){
            $r = unlink($errorCacheFile);
        }
    }

    if (!file_exists($errorCacheFile)) {
        createCacheErrorReporting($errorCacheDir, $errorCacheFile, $mb5);
    } elseif ($mb5 != $ERROR_INI_MB5) {
        createCacheErrorReporting($errorCacheDir, $errorCacheFile, $mb5);
    }
}

function createCacheErrorReporting($errorCacheDir, $errorCacheFile, $mb5)
{
    $errors = config::errors();
    $all = $errors->all();
    $s = [];
    if ($errors->E_ALL == 1) {
        $b = '<?php error_reporting(E_ALL);  $ERROR_INI_MB5 = "' . $mb5 . '";';
    } else {
        foreach ($all as $a => $i) {
            $c = mb_substr($a, 0, 2, "UTF-8");
            if ($c != 'E_' || $a == 'E_ALL' || $i != 1) {
                continue;
            }
            $s[] = $a;
        }

        if (count($s) > 0) {
            $b = '<?php error_reporting(' . implode(' | ', $s) . '); $ERROR_INI_MB5 = "' . $mb5 . '";';
        } else {
            $b = '<?php $ERROR_INI_MB5 = "' . $mb5 . '";';
        }
    }
    files::createDir($errorCacheDir);
    file_put_contents($errorCacheFile, $b);
    require $errorCacheFile;
}
