<?php

namespace system\core\model;

use system\core\model\traits\insert;
use system\core\model\traits\update;
use system\core\model\traits\delete;
use system\core\model\traits\save;
use system\core\model\traits\where;
use system\core\model\traits\join;
use system\core\model\traits\pagination;

abstract class model
{
    use insert;
    use update;
    use delete;
    use save;
    use where;
    use join;
    use pagination;

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

    private function from(string $from): self
    {
        $this->_from = $from;
        return $this;
    }

    private function select(string $select): self
    {
        $this->_select = $select;
        return $this;
    }

    private function limit($limit): self
    {
        $this->_limit = ' LIMIT ' . $limit . ' ';
        return $this;
    }

    private function sort(string $type, string $name = null): self
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

    private function all(): array
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

    private function get(): self
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

    private function sql(): void
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

    private function find($id): ?self
    {
        $result = db()->fetch('SELECT * FROM ' . $this->_table . ' WHERE `' . $this->_id . '` = :' . $this->_id . ' ', [$this->_id => $id], get_class($this));
        return $result ? $result : null;
    }

    public static function __callStatic(string $method, array $parameters)
    {
        if(method_exists((new static), $method)){
            return (new static)->$method(...$parameters);
        }  
    }

    public function __call(string $method, array $param)
    {
        if(method_exists($this, $method)){
            return $this->$method(...$param);
        }
    }
}
