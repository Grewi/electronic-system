<?php

namespace system\core\sass;

abstract class sass
{
    protected $input = [];
    protected $output = [];
    protected $list = [];
    protected $compileList = [];
    protected $mini = true;
    protected $data = [
        'android-arm'     => 'android-arm/dart-sass/sass',
        'android-arm64'   => 'android-arm64/dart-sass/sass',
        'android-ia32'    => 'android-ia32/dart-sass/sass',
        'android-x64'     => 'android-x64/dart-sass/sass',
        'linux-arm'       => 'linux-arm/dart-sass/sass',
        'linux-arm-musl'  => 'linux-arm-musl/dart-sass/sass',
        'linux-ia32'      => 'linux-ia32/dart-sass/sass',
        'linux-ia32-musl' => 'linux-ia32-musl/dart-sass/sass',
        'linux-arm64'     => 'linux-arm64/dart-sass/sass',
        'linux-arm64-musl'=> 'linux-arm64-musl/dart-sass/sass',
        'linux-x64'       => 'linux-x64/dart-sass/sass',
        'linux-x64-musl'  => 'linux-x64-musl/dart-sass/sass',
        'macos-arm64'     => 'macos-arm64/dart-sass/sass',
        'macos-x64'       => 'macos-x64/dart-sass/sass',
        'windows-ia32'    => 'windows-ia32/dart-sass/sass.bat',
        'windows-x64'     => 'windows-x64/dart-sass/sass.bat',
    ];

    protected $url = 'https://github.com/sass/dart-sass/releases/download/1.72.0/';
    protected $file = [
        'android-arm'      => 'dart-sass-1.72.0-android-arm.tar.gz',
        'android-arm64'    => 'dart-sass-1.72.0-android-arm64.tar.gz',
        'android-ia32'     => 'dart-sass-1.72.0-android-ia32.tar.gz',
        'android-x64'      => 'dart-sass-1.72.0-android-x64.tar.gz',
        'linux-arm'        => 'dart-sass-1.72.0-linux-arm.tar.gz',
        'linux-arm-musl'   => 'dart-sass-1.72.0-linux-arm-musl.tar.gz',
        'linux-ia32'       => 'dart-sass-1.72.0-linux-ia32.tar.gz',
        'linux-ia32-musl'  => 'dart-sass-1.72.0-linux-ia32-musl.tar.gz',
        'linux-arm64'      => 'dart-sass-1.72.0-linux-arm64.tar.gz',
        'linux-arm64-musl' => 'dart-sass-1.72.0-linux-arm64-musl.tar.gz',
        'linux-x64-musl'   => 'dart-sass-1.72.0-linux-x64-musl.tar.gz',
        'linux-x64'        => 'dart-sass-1.72.0-linux-x64.tar.gz',
        'macos-arm64'      => 'dart-sass-1.72.0-macos-arm64.tar.gz',
        'macos-x64'        => 'dart-sass-1.72.0-macos-x64.tar.gz',
        'windows-ia32'     => 'dart-sass-1.72.0-windows-ia32.zip',
        'windows-x64'      => 'dart-sass-1.72.0-windows-x64.zip',
    ];

    /**
     * Добавляет в очередь стиль по имени
     */
    public function name(string $name)
    {
        if (isset($this->input[$name]) && isset($this->output[$name])) {
            $this->compileList[$name] = [
                'input' => $this->slash($this->input[$name]),
                'output' => $this->slash($this->output[$name]),
            ];
            return $this;
        }
    }

    /**
     * Добавляет в очередь все стили из массива list
     */
    public function list()
    {
        if (is_iterable($this->list)) {
            foreach ($this->list as $name) {
                $this->name($name);
            }
            return $this;
        }
    }

    public function compile($name = null)
    {
        $data = config('sass', 'data');
        if (!isset($this->data[$data])) {
            echo 'Не удалось определить конфигурацию системы, проверьте значение "data" в файле конфигурации .sass.ini' . PHP_EOL . 'Список возможных значений в конфигурации можно посмотреть по команде php e style/info';
            exit();
        }

        $fileData = APP . '/cache/sass/' . $this->data[$data];
        if(!file_exists($fileData)){
            $this->dowload($this->url . $this->file[$data], $this->file[$data]);
        }

        foreach ($this->compileList as $a => $i) {
            $input = ROOT . $i['input'];
            $output = ROOT . $i['output'];
            exec($fileData . ' ' . $input . ' ' . $output);
            if ($this->mini) {
                $output = str_replace('.css', '.min.css', $output);
                exec($fileData . ' ' . $input . ' ' . $output . ' --style compressed');
            }

            echo $a . ' compile ' .  PHP_EOL;
        }
        echo 'Процесс завершён' . PHP_EOL;
    }

    private function slash($str)
    {
        $str = str_replace('\\', '/', $str);
        return '/' . trim($str, '/');
    }

    public function info()
    {
        foreach ($this->data as $a => $i) {
            echo $a . PHP_EOL;
        }
    }

    public function dowload($url, $fileName)
    {
        $dataDir = config('sass', 'data');
        if (!file_exists(APP . '/cache/sass/')) {
            mkdir(APP . '/cache/sass/', 0755, true);
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        $fp = fopen(APP . '/cache/sass/' . $fileName, 'w');
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        curl_close($ch);
        fclose($fp);

        if ($code != 200) {
            echo 'Не удалось получить файл' . PHP_EOL;
            exit();
        }

        $pathinfo = pathinfo($fileName);

        if (isset($pathinfo['extension']) && $pathinfo['extension'] == 'gz') {

            // декомпрессия из gz
            $p = new \PharData(APP . '/cache/sass/' . $fileName);
            $p->decompress(); 

            if(file_exists(APP . '/cache/sass/' . $fileName)){
                // unlink(APP . '/cache/sass/' . $fileName);
            }
            
            // распаковка из tar
            $phar = new \PharData(APP . '/cache/sass/' . $pathinfo['filename']);
            $phar->extractTo(APP . '/cache/sass/' . $dataDir);

            if(file_exists(APP . '/cache/sass/' . $pathinfo['filename'])){
                // unlink(APP . '/cache/sass/' . $pathinfo['filename']);
            }
        }

        if (isset($pathinfo['extension']) && $pathinfo['extension'] == 'zip') {
            $zip = new \ZipArchive;
            $res = $zip->open(APP . '/cache/sass/' . $fileName);
            if ($res === TRUE) {
                $zip->extractTo(APP . '/cache/sass/' . $dataDir);
                $zip->close();
            } else {
                echo 'Не удалось обработать данные.' . PHP_EOL;
                exit();
            }

            if(file_exists(APP . '/cache/sass/' . $fileName)){
                unlink(APP . '/cache/sass/' . $fileName);
            }
        }
    }
}
