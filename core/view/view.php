<?php
declare(strict_types = 1);
namespace system\core\view;
use system\core\config\config;
use system\core\view\tempParsingTrait;

!INDEX ? exit('exit') : true;

class view 
{
    use tempParsingTrait;

    //private $cache = true; //Включить кеширование
    protected $compile = false; // Принудительная перекомпиляция
    protected $cacheDir = APP . '/cache/views';
    protected $viewsDir = APP . '/views';
    protected $maxInclude = 100;
    protected $countInclude = 0;
    protected $content = '';
    protected $filePath = '';
    protected $validElement = "/^[a-zA-Z0-9а-яА-ЯёЁ\-_]+$/u"; //Допустимые символы в переменных  

    public function __construct(string $filePath, array $data = [], bool $include = false) 
    {
        try{
            $this->filePath = $filePath;
            $fullPathOriginal = $this->viewsDir . '/' . $filePath . '.php';
            $fullPathCache = $this->cacheDir . '/' . $filePath . '.php';
            $this->content = $this->getFile($fullPathOriginal);

            //Время последнего изменения в шаблонах и файла в кеше
            $timeCacheFile = file_exists($fullPathCache) ? filemtime($fullPathCache) : 0; 
            $timeOriginal = $this->foldermtime($this->viewsDir);
            //Файл изменился или включена принудительная перекомпиляция
            if($timeOriginal > $timeCacheFile || $this->compile){
                $this->compile();
            }

            if(!$include){
                $this->out($data);
            }

        }catch(\TempException $e){
            exit($e->message);
        } 
    }

    private function compile()
    {
        $this->useLauoyt(); // Сборка по шаблону
        $this->include();   // Подключение файлов
        $this->variable();  // Переменные
        $this->lang();      // Языковые переменные
        $this->csrf();      // Токен csrf
        $this->clearing();  // Очистка
        $this->save();      // Сохранение файла в кеш
    }

    public function getFile( string $path, string $fileName = '') :string
    {
        if (file_exists($path)) {
            $temp = file_get_contents($path);
        } else {
            throw new \TempException('Файл ' . $path . ' ' . $fileName . ' не найден!');
        }
        return $temp;
    }   

    //Если есть тег use используем шаблон
    private function useLauoyt() : void
    {
        $temp = $this->content;
        preg_match('/\<use\s*(.*?)\s*\>/si', $temp, $matches);
        if($matches){
            $a = $this->parserHtmlTag($matches[1]);
            $aa = array_shift($a);
            $html = 'layout/' . $aa;
            if($matches){
                $layout = $this->getFile(APP . '/views/' . $html . '.php', $html);
                $adm = '<?php $_SERVER[\'viewList\'][] = \'' . addslashes($html) . '\'; ?>';
                $layout = $adm . $layout;
                preg_match_all('/\<block\s*name=\"(.*?)\"\s*\/*>/si', $layout, $matches2);
                foreach($matches2[1] as $a => $i){
                    preg_match('/\<block\s*name=\"' . $i . '\"\s*\>(.*?)\<\/block\s*>/si', $temp, $m);
                    $r = $m ? $m[1] : '';
                    $layout = str_replace($matches2[0][$a] , $r, $layout);
                }
                $this->content = $layout;
            }            
        }
    }

    //Подключаем внешние файлы
    private function include() : void
    {
        $temp = $this->content;
        $this->countInclude++;
        preg_match_all('/\<include \s*file\s*=\s*"(.*?)"\s*\/*\>/si', $temp, $matches);
        foreach($matches[1] as $key => $i){
            $inc = '<?php include \'' . $this->cacheDir . '/' . $i . '.php\' ?>';
            $temp = str_replace($matches[0][$key], $inc, $temp);
            $class = __CLASS__;
            new $class($i, [], true);
        }
        $this->content = $temp;          
    }
    
    private function variable() : void
    {
        $temp = $this->content;
        preg_match_all('/\{\{\s*\$(.*?)\s*\}\}(else\{\{(.*?)}\})?/si', $temp, $matches);
        foreach ($matches[1] as $a => $i) {
            $r = $matches[3][$a] !== '' ? (string)$matches[3][$a] : '""'; //Значение по умолчанию
            $temp = str_replace($matches[0][$a], '<?= isset($' . $i . ') && (is_string($' . $i . ') || is_numeric($' . $i . ') ) ? $' . $i . ' : ' . $r . '; ?>', $temp);
        }
        $this->content = $temp;
    }

    private function lang() : void
    {
        $temp = $this->content;
        preg_match_all('/\{\{\s*lang\((.*?)\)\s*\}\}/si', $temp, $matches);
        foreach ($matches[1] as $a => $i) {
            $s = explode(',', $i);
            $temp = str_replace($matches[0][$a], '<?= lang(\'' . $s[0] . '\',\'' . $s[1] . '\') ?>', $temp);
        }
        $this->content = $temp;
    }

    //Принимает два параметра type= input/token и name
    private function csrf() : void
    {
        $temp = $this->content;
        preg_match_all('/\<csrf\s*(.*?)\s*\\/*>/si', $temp, $matches);
        foreach($matches[0] as $key => $i){
            $a = $this->parserHtmlTag($matches[1][$key]);
            if(isset($a['type']) && $a['type'] == 'input' && isset($a['name']) && !empty($a['name'])){
                $temp = str_replace($matches[0][$key], '<input value="<?= csrf(\'' . $a['name'] . '\') ?>" name="csrf" hidden >', $temp);
            }
            
            elseif(isset($a['type']) && $a['type'] == 'token' && isset($a['name']) && !empty($a['name'])){
                $temp = str_replace($matches[0][$key], '<?= csrf(\'' . $a['name'] . '\') ?>', $temp);
            }

            else{
                $temp = str_replace($matches[0][$key], '', $temp);
            }

        }
        $this->content = $temp; 
    }

    private function clearing() : void
    {
        $temp = $this->content;
        $temp = preg_replace('/\<\!--(.*?)-->/si', '', $temp);
        $this->content = $temp;
    }

    private function save() : void
    {
        $filePath = $this->filePath;
        $a = explode('/', $filePath);
        array_pop($a);
        $a = implode('/', $a);

        if(!file_exists($this->cacheDir . '/' . $filePath . '.php') /*|| !$this->cache*/){
            if(!file_exists($this->cacheDir . '/' . $a)){
                mkdir($this->cacheDir . '/' . $a, 0755, true);
            } 
        }
        $adm = '<?php $_SERVER[\'viewList\'][] = \'' . addslashes($filePath) . '\'; ?>';

        file_put_contents($this->cacheDir . '/' . $filePath . '.php', $adm . $this->content);
    }

    //Последнее изменение в директории
    function foldermtime(string $dir)
    {
        $foldermtime = 0;
        $flags = \FilesystemIterator::SKIP_DOTS | \FilesystemIterator::CURRENT_AS_FILEINFO;
        $it = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir, $flags));
        while ($it->valid()) {
            if (($filemtime = $it->current()->getMTime()) > $foldermtime) {
                $foldermtime = $filemtime;
            }
            $it->next();
        }
        return $foldermtime ?: null;
    }

    public function out(array $data) : void
    {
        extract($data);
        if(file_exists($this->cacheDir . '/' . $this->filePath . '.php')){
            require $this->cacheDir . '/' . $this->filePath . '.php';
        }else{
            throw new \TempException('Отсутствует файл вывода для шаблона "' . $this->filePath . '"!');
        }
    }
}