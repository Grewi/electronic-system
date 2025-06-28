<?php 
namespace system\core\model\traits;

trait pagination 
{
    private function pagin($limit = null,  $sortById = true)
    {
        if (isset($_GET['str']) && is_numeric($_GET['str']) && $_GET['str'] > 0) {
            $str = (int) $_GET['str'];
        } else {
            $str = 1;
        }

        if (is_null($limit)) {
            $limit = $this->_limitDirection;
        }

        $this->_offset = ' OFFSET ' . (($str * $limit) - $limit);
        if ($sortById) {
            $this->_sort = ' ORDER BY ' . $this->_id . ' ' . $this->_sortDirection;
        }

        $this->_limit = ' LIMIT ' . $limit;

        $count = $this->count(); // Количество строк в базе
        $countStr = ceil($count / $limit); // Количество страниц
        if ($countStr > 1) {
            $r = [];
            for ($i = 1; $i <= $countStr; $i++) {
                $r[$i] = $i == $str ? 'active' : '';
            }
            $this->paginationLine = $r;
        }

        if ($str > 1) {
            $this->paginationPriv = $str - 1;
        }

        if ($str < $countStr) {
            $this->paginationNext = $str + 1;
        }
        $this->paginationActive = $str;

        return $this;
    }

    /**
     * Метод вывода пагинации. Устарел.
     * @param string $url
     * @return array
     */
    private function pagination(string $url = null): array
    {
        return [
            'line' => $this->paginationLine,
            'priv' => $this->paginationPriv,
            'next' => $this->paginationNext,
            'url'  => $url,
            'actual' => $this->paginationActive,
        ];
    }

    protected function paginList()
    {
        $r = [];
        if (count($this->paginationLine) > 0) {
            //Если текущая страница рядом с концом или началом увеличиваем край
            $countLi = count($this->paginationLine);
            $min = $this->paginationActive > 2 ? 2 : 6;
            $max = $this->paginationActive < $countLi - 2 ? $countLi - 2 : $countLi - 6;
            if ($this->paginationPriv  > 0){
                $r[] = [
                    'type' => 'priv',
                    'url' =>  eGetReplace('str', $this->paginationPriv),
                    'text' => null,
                    'active' => true,
                ];
            }else{
                $r[] = [
                    'type' => 'priv',
                    'url' =>  null,
                    'text' => null,
                    'active' => false,
                ]; 
            }
            foreach ($this->paginationLine as $key => $i){
                // Первые, последние и рядом с актуальной страницей
                if ($key <= $min || ($key >= $this->paginationActive - 3 && $key <= $this->paginationActive + 3) || $key > $max){
                    if ($i == 'active'){
                        $r[] = [
                            'type' => 'el',
                            'url' =>  eGetReplace('str', $key),
                            'text' => $key,
                            'active' => true,
                        ];
                    }else{
                        $r[] = [
                            'type' => 'el',
                            'url' =>  eGetReplace('str', $key),
                            'text' => $key,
                            'active' => false,
                        ];
                    }
                }else{
                    //Многоточие
                    if($key == $min+1 || $key == $this->paginationActive + 4){
                        $r[] = [
                            'type' => 'ellipsis',
                            'url' =>  '',
                            'text' => null,
                            'active' => false,
                        ];
                    }
                }
            }
            if ($this->paginationNext  > 0){
                $r[] = [
                    'type' => 'next',
                    'url' =>  eGetReplace('str', $this->paginationNext),
                    'text' => null,
                    'active' => true,
                ];
            }else{
                $r[] = [
                    'type' => 'next',
                    'url' =>  null,
                    'text' => null,
                    'active' => false,
                ];
            }
        }
        return $r;
    }
}