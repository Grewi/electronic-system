<?php
namespace system\console;

class updateSystem
{
    private $zip = 'https://github.com/Grewi/electronic/archive/master.zip';
    private $file = 'update.zip';
    private $root = '';
    private $path = '';
    private $recPath = '';

    public function index()
    {
        $this->root = ROOT;
        $this->path = $this->root . '/update/';

        $this->download();
        $this->extract();
        $this->rec();
        $this->delete();
    }

    private function download()
    {
        if (!file_exists($this->path)) {
            mkdir($this->path, 0755, true);
        }
        $dest_file = @fopen($this->path . $this->file, "w");
        $resource = curl_init();
        curl_setopt($resource, CURLOPT_URL, $this->zip);
        curl_setopt($resource, CURLOPT_FILE, $dest_file);
        curl_setopt($resource, CURLOPT_HEADER, 0);
        curl_setopt($resource, CURLOPT_FOLLOWLOCATION, true);
        curl_exec($resource);
        curl_close($resource);
        fclose($dest_file);
    }

    private function extract()
    {
        $zip = new \ZipArchive();
        if ($zip->open($this->path . $this->file) === TRUE) {
            $zip->extractTo($this->path . 'zip');
            $zip->close();
        }
    }

    private function rec()
    {
        $this->recPath = $this->path . 'zip/electronic-master/system';
        $this->copy($this->recPath);

        $this->cleaning($this->root . '/system');
    }

    private function copy($dir)
    {
        $files = scandir($dir);

        foreach ($files as $i) {
            if ($i == '.' || $i == '..') {
                continue;
            }
            if (is_dir($dir . '/' . $i)) {
                $this->copy($dir . '/' . $i);
            } else {
                if (!file_exists($dir)) {
                    mkdir($dir, 0755, true);
                }
                $n = str_replace($this->recPath, '', $dir . '/' . $i);
                $s = $this->root . '/system' . $n;
                if (file_exists($s) && file_exists($dir . '/' . $i) && md5_file($s) != md5_file($dir . '/' . $i)) {
                    copy($dir . '/' . $i, $s);
                }
            }
        }
    }

    private function cleaning($dir)
    {
        $files = scandir($dir);
        foreach ($files as $i) {
            if ($i == '.' || $i == '..') {
                continue;
            }

            $z = $this->path . 'zip/electronic-master/system/' . $i;
            $s = $dir . '/' . $i;
            if(!file_exists($z)){
                if (is_dir($s)) {
                    $this->delete($s);
                }else{
                    unlink($s);
                }
            }
        }
    }

    private function delete($path = null)
    {
        $path = $path ? $path : $this->path;
        if (is_dir($path) === true) {
            $files = array_diff(scandir($path), array('.', '..'));
            foreach ($files as $file) {
                $this->delete(realpath($path) . '/' . $file);
            }
            return rmdir($path);
        } else if (is_file($path) === true) {
            return unlink($path);
        }
        return false;
    }
}

