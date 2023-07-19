<?php
namespace system\install_system\view;

trait tempParsingTrait
{
    private function parserHtmlTag(string $parametrs, bool $valid = true)
    {
        preg_match_all('/\s*(.*?)=\"(.*?)\"\s*/siu', $parametrs, $m);
        $result = [];
        foreach($m[0] as $key=> $i){
            if( (!preg_match($this->validElement, $m[1][$key], $resut) || !preg_match($this->validElement, $m[2][$key], $resut)) && $valid ){
                throw new \TempException('Недопустимое имя переменной в цикле ' . $parametrs . ' в шаблоне "' . $this->filePath . '"!');
                continue;
            }
            $result[mb_strtolower($m[1][$key])] = $m[2][$key];
            
        }
        return $result;
    }
}