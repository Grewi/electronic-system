<?php 

echo '--------------ERROR----------------' . PHP_EOL;
echo $message . PHP_EOL;
echo $exeption->getFile() . ' - (' .  $exeption->getLine() .')' . PHP_EOL;
echo PHP_EOL;
foreach ($exeption->getTrace() as $e){
    echo $e['file'] . ' ' 
    . '(' . (isset($e['line']) ? $e['line'] : '') . ') ' 
    . (isset($e['class']) ? $e['class'] : '') . ' '
    . (isset($e['function']) ? $e['function'] : '') . PHP_EOL;
}
echo '-----------------------------------' . PHP_EOL;