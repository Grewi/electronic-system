<?php

declare(strict_types=1);

class FileException extends Exception
{
    public $message = '';
    public function __construct(string $message = '', int $code = 1)
    {
        exeptionVar::dump($this, $message, $code);
    }
}

class GlobalException extends Exception
{
    public function __construct(string $message = '', int $code = 1)
    {
        exeptionVar::dump($this, $message, $code);
    }
}

class MaxCountIncludeTemp extends Exception
{
    public $message = '';
    public function __construct(string $message = '', int $code = 0)
    {
        exeptionVar::dump($this, $message, $code);
    }
}

class TempException extends Exception
{
    public $message = '';
    public function __construct(string $message = '', int $code = 0)
    {
        exeptionVar::dump($this, $message, $code);
    }
}

class exeptionVar
{
    public static function dump($exeption, $message, $code)
    {
        http_response_code(503);
        if(\system\core\config\config::globals('dev')){
            require SYSTEM . '/exception/tempDew.php';
        }else{
            require SYSTEM . '/exception/tempProd.php';
        }
        exit();
    }
}
