<?php declare(strict_types=1);

class FileException extends Exception
{
  public $message = '';
  public function __construct(string $message = '', int $code = 1)
  {
    parent::__construct($message, $code);
  }
}

class GlobalException extends Exception
{
  public function __construct(string $message = '', int $code = 1)
  {
    parent::__construct($message, $code);
  }
}

class MaxCountIncludeTemp extends Exception
{
  public $message = '';
  public function __construct(string $message = '', int $code = 0)
  {
    parent::__construct($message, $code);
  }
}

class TempException extends Exception
{
  public $message = '';
  public function __construct(string $message = '', int $code = 0)
  {
    parent::__construct($message, $code);
  }
}
