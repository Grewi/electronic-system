<?php
namespace system\console;

class sass
{
    private function start()
    {
        $fileSass = APP . '/system/sass/sass.php';
        $classSass = '\\electronic\\sass\\sass';
        if(!file_exists($fileSass)){
            $this->createSysyemSass();
            echo 'Создан файл ' . $fileSass . PHP_EOL . 
            'Для компиляции стилей необходимо его заполнить' . PHP_EOL . 
            'http://grewi.ru/blogs/27-kompilyaciya-css-faylov' . PHP_EOL;
            exit();
        }
        return new $classSass();
    }
    public function compile()
    {
        $sass = $this->start();
        if(isset(ARGV[2])){
            $name = ARGV[2];
            $sass->name($name)->compile();
        }else{
            $sass->list()->compile();
        }
        exit();
    }

    public function info()
    {
        $sass = $this->start();
        $sass->info();
    }

    private function createSysyemSass()
    {
        if (!file_exists(APP . '/system/sass')) {
            mkdir(APP . '/system/sass', 0755, true);
        }

        $data = '<?php 
        namespace electronic\sass;
        
        class sass extends \system\core\sass\sass
        {
            public $mini = false;
        
            // Путь к scss файлам \'имя\' => \'путь\'
            public $input = [
                \'style\'     => \'/public/style/style.scss\',
                \'bootstrap\' => \'/public/adm/bootstrap.scss\',
            ];
        
            // Путь к css файлам \'имя\' => \'путь\'
            public $output = [
                \'style\'     => \'/public/style/test.css\',
                \'bootstrap\' => \'/public/adm/bootstrap.css\',
            ];
        
            // Список имён, которые будут компилироваться в втоматическом режиме php e style
            public $list = [
                \'style\', \'bootstrap\',
            ];
        }';
        file_put_contents(APP . '/system/sass/sass.php', $data);
    }
}



