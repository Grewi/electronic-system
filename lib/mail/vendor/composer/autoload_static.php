<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit194d2d22387dbe335a53c7c82bcb3d01
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit194d2d22387dbe335a53c7c82bcb3d01::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit194d2d22387dbe335a53c7c82bcb3d01::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
