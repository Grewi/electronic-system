<?php

namespace system\core\model;

use system\core\model\traits\insert;
use system\core\model\traits\update;
use system\core\model\traits\delete;
use system\core\model\traits\save;
use system\core\model\traits\where;
use system\core\model\traits\join;
use system\core\model\traits\pagination;
use system\core\model\traits\group;
use system\core\model\traits\sort;
use system\core\model\traits\filter;

#[\AllowDynamicProperties]
abstract class model
{
    use insert;
    use update;
    use delete;
    use save;
    use where;
    use join;
    use pagination;
    use group;
    use sort;
    use filter;

    protected $_databaseName = 'database';
    protected $_table = '';
    protected $_idNumber = 0;
    protected $_id = 'id';
    protected $_from;
    protected $_paginCount = 20;
    protected $_where = '';
    protected $_this_where_count = 1;
    protected $_bind = [];
    protected $_limit = '';
    protected $_limitDirection = 20;
    protected $_sort = '';
    protected $_sortDirection = 'DESC'; //ASC or DESC
    protected $_select = '*';
    protected $_offset = '';
    protected $_leftJoin = '';
    protected $_group = '';

    protected $paginationLine = [];
    protected $paginationPriv = 0;
    protected $paginationNext = 0;
    protected $paginationActive = 0;

    protected $_data = [];

    public function __construct()
    {
        if (empty($this->_table)) {
            $c = explode('\\', get_called_class());
            $this->_table = array_pop($c);
        }
        $this->_from = $this->_table;
    }

    private function from(string $from)
    {
        $this->_from = $from;
        return $this;
    }

    private function select(string $select)
    {
        $this->_select = $select;
        return $this;
    }

    private function limit($limit)
    {
        $this->_limit = ' LIMIT ' . $limit . ' ';
        return $this;
    }

    private function sort(string $type, string $name = null)
    {
        $name = $name ? $name : $this->_id;
        if(empty($this->_sort)){
            $this->_sort = ' ORDER BY ';
        }else{
            $this->_sort = $this->_sort . ', ';
        }
        if ($type == 'asc') {
            $this->_sort = $this->_sort . $name . ' ASC';
        } elseif ($type == 'desc') {
            $this->_sort = $this->_sort . $name . ' DESC';
        }
        return $this;
    }

    private function count(): string
    {
        $str = 'SELECT COUNT(*) as count FROM ' .
            $this->_from . ' ' .
            $this->_leftJoin . ' ' .
            $this->_where . ' ' .
            $this->_group;

        return db($this->_databaseName)->fetch($str, $this->_bind, get_class($this))->count;
    }

    private function summ($name): float
    {
        $str = 'SELECT SUM(`' . $name . '`) as `summ` FROM ' .
            $this->_from . ' ' .
            $this->_leftJoin . ' ' .
            $this->_where . ' ' .
            $this->_group;

        return (int)db($this->_databaseName)->fetch($str, $this->_bind, get_class($this))->summ;
    }

    private function all(): array
    {
        $str = 'SELECT ' . $this->_select . ' ' . ' FROM ' .
            $this->_from . ' ' .
            $this->_leftJoin . ' ' .
            $this->_where . ' ' .
            $this->_group . ' ' .
            $this->_sort . ' ' .
            $this->_limit . ' ' .
            $this->_offset;
        return db($this->_databaseName)->fetchAll($str, $this->_bind, get_class($this));
    }

    private function get()
    {
        $str = 'SELECT ' . $this->_select . ' ' . ' FROM ' .
            $this->_from . ' ' .
            $this->_leftJoin . ' ' .
            $this->_where . ' ' .
            $this->_group . ' ' .
            $this->_sort . ' ' .
            $this->_limit . ' ' .
            $this->_offset;

        return db($this->_databaseName)->fetch($str, $this->_bind, get_class($this));
    }

    private function sql($type = true): void
    {
        $str = 'SELECT ' . $this->_select . ' ' . ' FROM ' .
            $this->_from . ' ' .
            $this->_leftJoin . ' ' .
            $this->_where . ' ' .
            $this->_group . ' ' .
            $this->_sort . ' ' .
            $this->_limit . ' ' .
            $this->_offset;
            
        if($type){
            dump($this->_bind);
            dump($str);            
        }else{
            print_r($this->_bind);
            print_r($str);
        }


        exit();
    }

    private function find($id = null)
    {
        if(!$id){
            return null;
        }
        $result = db($this->_databaseName)->fetch('SELECT * FROM ' . $this->_table . ' WHERE `' . $this->_id . '` = :' . $this->_id . ' ', [$this->_id => $id], get_class($this));
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

    public function __get($property)
    {
        return null;
    }
}
