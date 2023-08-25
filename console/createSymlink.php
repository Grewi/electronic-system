<?php

namespace system\console;

class createSymlink
{
    public function index()
    {
        $target = ARGV[2];
        $link = ARGV[3];

        $_linkDir = pathinfo(getcwd() . DIRECTORY_SEPARATOR . $link);
        $linkDir = $_linkDir['dirname'];
        createDir($linkDir);

        if(!file_exists(getcwd() . DIRECTORY_SEPARATOR . $target)){
            exit('Файл не найден!');
        }

        $a1 = getcwd() . DIRECTORY_SEPARATOR . $target;
        $a2 = getcwd() . DIRECTORY_SEPARATOR . $link;

        function linkSlash($a)
        {
            return str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $a);
        }

        symlink(linkSlash($a1), linkSlash($a2));
    }


}
