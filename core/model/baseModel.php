<?php

namespace system\core\model;

use system\core\model\insertTrait;
use system\core\model\updateTrait;
use system\core\model\deleteTrait;

abstract class baseModel
{
    use insertTrait;
    use updateTrait;
    use deleteTrait;

    private $_table = '';
    private $_idNumber = 0;
    private $_id = 'id';
    private $_from;
    private $_paginCount = 20;
    private $_where = '';
    private $_this_where_count = 1;
    private $_bind = [];
    private $_limit = '';
    private $_limitDirection = 20;
    private $_sort = '';
    private $_sortDirection = 'DESC'; //ASC or DESC
    private $_select = '*';
    private $_offset = '';
    private $_leftJoin = '';

    private $paginationLine = [];
    private $paginationPriv = 0;
    private $paginationNext = 0;
    private $paginationActive = 0;

    private $_data = [];

    public function __construct()
    {
        if (empty($this->_table)) {
            $c = explode('\\', get_called_class());
            $this->_table = array_pop($c);
        }
        $this->_from = $this->_table;
    }

    private function from($from)
    {
        $this->_from = $from;
        return $this;
    }

    private function where($p1, $p2 = null, $p3 = null)
    {
        $count = $this->_this_where_count++;
        $sep = $this->_where == '' ? ' WHERE' : ' AND';
        $pp1 = str_replace('.', '_', $p1) . '_' . $count;
        if (is_null($p2) && is_null($p3)) {
            $this->_where .= $sep . ' `' . $this->_id . '` = :' . $this->_id . ' ';
            $this->_bind[$this->_id] = $p1;
            $this->_data = array_merge([$this->_id => $p1]);
            $this->_idNumber = $p1;
        } elseif (is_null($p3)) {
            $this->_where .= $sep . ' ' . $p1 . ' = :' . $pp1  . ' ';
            $this->_bind[$pp1] = $p2;
            $this->_data = array_merge([$p1 => $p2]);
            if ($p1 == $this->_id) {
                $this->_idNumber = $p2;
            }
        } else {
            $this->_where .= $sep . ' ' . $p1 . ' ' . $p2 . ' :' . $pp1 . ' ';
            $this->_bind[$pp1] = $p3;
            $this->_data = array_merge([$p1 => $p3]);
            if ($p1 == $this->_id) {
                $this->_idNumber = $p3;
            }
        }
        return $this;
    }

    private function whereNull($p1)
    {
        $sep = $this->_where == '' ? ' WHERE' : ' AND';
        $this->_where .= $sep . ' `' . $p1 . '` IS NULL ';
        return $this;
    }

    private function whereNotNull($p1)
    {
        $sep = $this->_where == '' ? ' WHERE' : ' AND';
        $this->_where .= $sep . ' `' . $p1 . '` IS NOT NULL ';
        return $this;
    }

    private function whereIn($p1, $arg)
    {
        $sep = $this->_where == '' ? ' WHERE' : ' AND';
        $arr = [];
        foreach ($arg as $i) {
            $count = $this->_this_where_count++;
            $pp1 = str_replace('.', '_', $p1) . '_' . $count;
            $this->_bind[$pp1] = $i;
            $arr[] = ':'.$pp1;
        }
        $str = implode(',', $arr);
        $this->_where .= $sep . ' ' . $p1 . ' IN (' . $str . ')';
        return $this;
    }

    private function whereStr(string $str, array $bind = [])
    {

        $this->_where .= $str;
        foreach ($bind as $key => $i) {
            $this->_bind[$key] = $i;
        }
        return $this;
    }



    private function leftJoin($tableName, $firstTable, $secondaryTable)
    {
        $lj = ' LEFT JOIN ' . $tableName . ' ON ' . $firstTable . ' = ' . $secondaryTable . ' ';
        $this->_leftJoin = $this->_leftJoin . $lj;
        return $this;
    }


    private function pagin($limit = null, $sortById = true): model
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

    private function pagination(string $url = null)
    {
        return [
            'line' => $this->paginationLine,
            'priv' => $this->paginationPriv,
            'next' => $this->paginationNext,
            'url'  => $url,
            'actual' => $this->paginationActive,
        ];
    }

    private function select($select)
    {
        $this->_select = $select;
        return $this;
    }

    private function limit($limit)
    {
        $this->_limit = ' LIMIT ' . $limit . ' ';
        return $this;
    }

    private function sort($type, $name = null)
    {
        $name = $name ? $name : $this->_id;
        if ($type == 'asc') {
            $this->_sort = ' ORDER BY ' . $name . ' ASC';
        } elseif ($type == 'desc') {
            $this->_sort = ' ORDER BY ' . $name . ' DESC';
        }
        return $this;
    }

    private function count(): string
    {
        $str = 'SELECT COUNT(*) as count FROM ' .
            $this->_from . ' ' .
            $this->_leftJoin . ' ' .
            $this->_where;
        return db()->fetch($str, $this->_bind, get_class($this))->count;
    }

    private function summ($name): float
    {
        $str = 'SELECT SUM(`' . $name . '`) as `summ` FROM ' .
            $this->_from . ' ' .
            $this->_leftJoin . ' ' .
            $this->_where;
        return (int)db()->fetch($str, $this->_bind, get_class($this))->summ;
    }

    private function all()
    {
        $str = 'SELECT ' . $this->_select . ' ' . ' FROM ' .
            $this->_from . ' ' .
            $this->_leftJoin . ' ' .
            $this->_where . ' ' .
            $this->_sort . ' ' .
            $this->_limit . ' ' .
            $this->_offset;
        return db()->fetchAll($str, $this->_bind, get_class($this));
    }

    private function get()
    {
        $str = 'SELECT ' . $this->_select . ' ' . ' FROM ' .
            $this->_from . ' ' .
            $this->_leftJoin . ' ' .
            $this->_where . ' ' .
            $this->_sort . ' ' .
            $this->_limit . ' ' .
            $this->_offset;

        return db()->fetch($str, $this->_bind, get_class($this));
    }

    private function sql()
    {
        $str = 'SELECT ' . $this->_select . ' ' . ' FROM ' .
            $this->_from . ' ' .
            $this->_leftJoin . ' ' .
            $this->_where . ' ' .
            $this->_sort . ' ' .
            $this->_limit . ' ' .
            $this->_offset;
        print_r($this->_bind);
        dd($str);
    }

    private function find($id)
    {
        return db()->fetch('SELECT * FROM ' . $this->_table . ' WHERE `' . $this->_id . '` = :' . $this->_id . ' ', [$this->_id => $id], get_class($this));
    }

    public static function __callStatic($method, $parameters)
    {
        if(method_exists((new static), $method)){
            return (new static)->$method(...$parameters);
        }  
    }

    public function __call($method, $param)
    {
        if(method_exists($this, $method)){
            return $this->$method(...$param);
        }
    }
}
