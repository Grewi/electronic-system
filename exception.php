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
    public static function header()
    {
        echo '
        <!doctype html>
        <html lang="ru">

        <head>
            <meta charset="utf-8" />
            <title>Electronic</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        </head>

        <body>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
        ';
    }

    public static function footer()
    {
        echo '
        </div>
        </div>
        </div>
        </body>
        </html>
        ';
    }

    public static function trace($exeption)
    {
        if (is_object($exeption)) {
            if ($exeption->getTrace()) {
?>
                <table class="table table-striped mt-3">
                    <thead>
                        <tr class="table-primary">
                            <th scope="col" width="50%">file</th>
                            <th scope="col">line</th>
                            <th scope="col">function</th>
                            <th scope="col">class</th>
                            <!-- <th scope="col">type</th> -->
                            <!-- <th scope="col">arg</th> -->
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        foreach ($exeption->getTrace() as $e) {
                        ?>
                            <tr>

                                <td class="text-primary-emphasis"><?= $e['file'] ?></td>
                                <td class="fw-bold"><?= $e['line'] ?></td>
                                <td class="fst-italic text-secondary"><?= $e['function'] ?></td>
                                <td class="fst-italic text-secondary"><?= $e['class'] ?></td>
                                <!-- <td><?= $e['type'] ?></td> -->
                                <!-- <td><?= var_dump($e['args']) ?></td> -->
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
<?php
            }
        }
    }

    public static function message($message)
    {
        if(!empty($message)){
        echo '
        <div class="alert alert-danger mt-3" role="alert">
        ' . $message . '
        </div>
        ';            
        }

    }

    private static function goust()
    {
        echo '<div class="alert alert-dark mt-3" role="alert">
            Произошла непредвиденная ошибка в работе сайта.
        </div>';
    }

    public static function dump($exeption, $message, $code)
    {
        if(\system\core\config\config::globals('dev')){
            self::header();
            self::message($message);
            self::trace($exeption);
            self::footer();
        }else{
            self::header();
            self::goust();
            self::footer();
        }
    }
}
