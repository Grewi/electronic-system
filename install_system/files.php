<?php
namespace system\install_system;
use system\core\app\app;

abstract class files
{
    protected $countFiles = 0;

    protected function structureInstall($structure, $path = '')
    {
        foreach ($structure as $a => $i) {
            if (is_array($i)) {
                self::structureInstall($i, $path . '/' . $a);
            } else {
                createDir(ROOT . $path);
                if (is_null($i)) {
                    createDir(ROOT . $path . '/' . $a);
                } else {
                    file_put_contents(ROOT . $path . '/' . $a, ($i ? $i : ''));
                }
            }
        }
    }

    protected function view(string $file, array $data = [])
    {
        $app = app::app();
        $content = file_get_contents(SYSTEM . '/install_system/' . $app->install->dirInstall . '/views/' . $file);

        preg_match_all('/\{\{\s*\$(.*?)\s*\}\}(else\{\{(.*?)}\})?/si', $content, $matches);
        foreach ($matches[1] as $a => $i) {
            $content = str_replace($matches[0][$a], isset($data[$i]) ? $data[$i] : '', $content);
        }
        return $content;
    }

    protected function copyDir($from, $to, $rewrite = true)
    {
        if (is_dir($from)) {
            @mkdir($to);
            $d = dir($from);
            while (false !== ($entry = $d->read())) {
                if ($entry == "." || $entry == ".."){
                    continue; 
                }    
                $this->copyDir($from . '/' . $entry, $to . '/' . $entry, $rewrite);
            }
            $d->close();
        } else {
            if (!file_exists($to) || $rewrite) {
                ++$this->countFiles;
                echo " Копирование:  $this->countFiles файлов             \r";
                copy($from, $to);
            }
        }
    }

    public function finish()
    {
        echo 'Копирование завершено                                                                                                                                           ' . PHP_EOL;
    }
}