<?php
namespace system\core\model\traits;

trait sort
{
    /**
     * Обработка get параметров sort 
     * @param array $listCol - Список колонок по которым допускается сортировка
     * @return mixed
     */
    protected function sorting(array $listCol = [])
    {
        if(!isset($_GET['sort']) || !in_array($_GET['sort'], $listCol)){
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