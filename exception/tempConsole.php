<?php

$fileLen = strlen('File');
$lineLen = strlen('Line');
$clssLen = strlen('Class');
$funcLen = strlen('Function');

// $a1 = shell_exec('mode con'); //for windows
// $col = exec('tput cols'); //
// dd($a1);

foreach ($exeption->getTrace() as $e) {
    $fileLen = strlen(localPathFile($e['file'])) > $fileLen ? strlen(localPathFile($e['file'])) : $fileLen;
    $lineLen = isset($e['line']) && strlen($e['line']) > $lineLen ? strlen($e['line']) : $lineLen;
    $clssLen = isset($e['class']) && strlen($e['class']) > $clssLen ? strlen($e['class']) : $clssLen;
    $funcLen = isset($e['function']) && strlen($e['function']) > $funcLen ? strlen($e['function']) : $funcLen;
}

$s = $fileLen + $lineLen + $clssLen + $funcLen;
$errorStr = str_pad('', (int)($s / 2), '-') . 'ERROR';
echo str_pad($errorStr, $s + 3, '-') . PHP_EOL;

echo $message . PHP_EOL;
echo localPathFile($exeption->getFile()) . ' - (' .  $exeption->getLine() . ')' . PHP_EOL;

echo str_pad('File', $fileLen, '-') . ' '
    . str_pad('Line', $lineLen, '-') . ' '
    . str_pad('Class', $clssLen, '-') . ' '
    . str_pad('Function', $funcLen, '-') . PHP_EOL;

foreach ($exeption->getTrace() as $e) {

    $file = localPathFile($e['file']);
    $line = isset($e['line']) ? $e['line'] : '';
    $class = isset($e['class']) ? $e['class'] : '';
    $function = isset($e['function']) ? $e['function'] : '';

    echo str_pad($file, $fileLen, ' ') . ' '
        . str_pad($line, $lineLen, ' ') . ' '
        . str_pad($class, $clssLen, ' ') . ' '
        . str_pad($function, $funcLen, ' ') . PHP_EOL;
}
$errorStr = str_pad('', (int)($s / 2 + 2), '-') . '^';
echo str_pad($errorStr, $s + 3, '-') . PHP_EOL;
