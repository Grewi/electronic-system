<?php
namespace system\core\model\traits;

trait sort
{
    /**
     * Обработка get параметров sort 
     * @param array $listCol - Список колонок по которым допускается сортировка
     * @param string $defaultSort - стролбец по умолчанию
     * @param string $defaultDirection - направление по умолчанию
     * @return mixed
     */
    protected function sorting(array $listCol = [], $defaultSort = '', $defaultDirection = '')
    {
        if(!isset($_GET['sort']) || !in_array($_GET['sort'], $listCol)){
            if(!empty($defaultSort) && !empty($defaultDirection)){
                $this->sort($defaultDirection, $defaultSort);
            }
            return $this;
        }
        if(isset($_GET['direction']) && $_GET['direction'] == 'desc'){
            $direction = 'desc';
        }else{
            $direction = 'asc';
        }
        $sort = $_GET['sort'];
        $this->sort($direction, $sort);
        return $this;
    }
}