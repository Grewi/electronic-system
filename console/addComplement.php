<?php

namespace system\console;

class addComplement
{
    public function index()
    {
        $parametr = ARGV[2];
        $parametr = preg_replace('/[^a-zA-Z0-9-_]/ui', '', $parametr);
        $url = 'https://codeload.github.com/Grewi/' . $parametr . '/zip/refs/heads/main';
        deleteDir(ROOT . '/updateSystem');
        createDir(ROOT . '/updateSystem');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        $fp = fopen(ROOT . '/updateSystem/system.zip', 'w');
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        curl_close($ch);
        fclose($fp);

        if ($code != 200) {
            deleteDir(ROOT . '/updateSystem');
            echo 'Не удалось получить файл' . PHP_EOL;
            exit();
        }

        $zip = new \ZipArchive;
        $res = $zip->open(ROOT . '/updateSystem/system.zip');
        if ($res === TRUE) {
            $zip->extractTo(ROOT . '/updateSystem');
            $zip->close();
        } else {
            deleteDir(ROOT . '/updateSystem');
            echo 'Не удалось обработать данные.' . PHP_EOL;
            exit();
        }

        unlink(ROOT . '/updateSystem/system.zip');

        $s = scandir(ROOT . '/updateSystem');
        foreach ($s as $i) {
            if ($i == '.' || $i == '..') {
                continue;
            }
            copyDir(ROOT . '/updateSystem/' . $i, ROOT . '/');
        }

        deleteDir(ROOT . '/updateSystem');

        echo 'Загрузка завершена!' . PHP_EOL;
    }
}
