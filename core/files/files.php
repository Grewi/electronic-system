<?php

namespace system\core\files;

class files
{
    public static function includeFile($path)
    {
        try {
            if (file_exists($path)) {
                require $path;
            } else {
                throw new \FileException('Файл ' . $path . ' не найден!');
            }
        } catch (\FileException $e) {
            var_dump($e);
            exit($e->message);
        }
    }

    public static function createDir($path)
    {
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }
    }

    public static function deleteDir($path)
	{
		if (is_dir($path) === true) {
			$files = array_diff(scandir($path), array('.', '..'));
			foreach ($files as $file) {
				self::deleteDir(realpath($path) . '/' . $file);
			}
			return @rmdir($path);
		} else if (is_file($path) === true) {
			return unlink($path);
		}
		return false;
	}

    public static function copyDir($from, $to, $rewrite = true)
	{
		if (is_dir($from)) {
			@mkdir($to);
			$d = dir($from);
			while (false !== ($entry = $d->read())) {
				if ($entry == "." || $entry == "..")
					continue;
					self::copyDir($from . '/' . $entry, $to . '/' . $entry, $rewrite);
			}
			$d->close();
		} else {
			if (!file_exists($to) || $rewrite)
				copy($from, $to);
		}
	}

	/**
	 * Принимает и объединяет строки через слеш
	 * Меняет обратный слеш
	 * Удаляет первый и последний слеш
	*/
	public static function path(string ...$a)
	{
		foreach($a as &$i){
			$i = str_replace('\\', '/', $i);
			$i = trim($i, '/');
		}
		return implode('/', $a);
	}

	public static function pathR(string ...$a)
	{
		foreach($a as &$i){
			$i = str_replace('/', '\\', $i);
			$i = trim($i, '\\');
		}
		return implode('\\', $a);
	}
}