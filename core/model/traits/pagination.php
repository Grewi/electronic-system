<?php 
namespace system\core\model\traits;

trait pagination 
{
    public function pagin($limit = null,  $sortById = true)
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

    public function pagination(string $url = null): array
    {
        return [
            'line' => $this->paginationLine,
            'priv' => $this->paginationPriv,
            'next' => $this->paginationNext,
            'url'  => $url,
            'actual' => $this->paginationActive,
        ];
    }
}