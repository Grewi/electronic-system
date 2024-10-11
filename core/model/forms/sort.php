<?php

namespace system\core\model\forms;

class sort 
{
    /**
     * Генератор ссылки для заголовка столбца в таблице
     * @param string $name Имя таблицы
     * @param string $lang Текст ссылки
     * @param array $params Параметры ['class' => 'btn', 'id' => 'user_sort']
     * @param string $iconDesc html иконки
     * @param string $iconAsc html иконки
     * @return string
     */
    public static function sortLink(string $name, string $lang, array $params = [], string $iconDesc = '', string $iconAsc = '')
    {
        $href = eGetReplace('sort', $name);
        if(isset($_GET['sort']) && $_GET['sort'] == $name){
            if(isset($_GET['direction']) && $_GET['direction'] == 'desc'){
                $hrefD = eGetReplace('direction', 'asc');
                $iconD = $iconDesc;
            }else{
                $hrefD = eGetReplace('direction', 'desc');
                $iconD = $iconAsc;
            }
        }
        $p = '';
        foreach($params as $a => $i){
            $p .= ' ' . $a . '="' . $i . '"';
        }

        if(isset($_GET['sort']) && $_GET['sort'] == $name){
            return '<a href="' . $hrefD . '" ' . $p . '>' . $lang . '</a>' . $iconD;
        }else{
            return '<a href="' . $href . '" ' . $p . '>' . $lang . '</a>';
        } 
    }
}