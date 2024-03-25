<?php
namespace system\core\model\traits;

trait where
{
    private $whereSeparator;

    private function _separatorWhere()
    {
        if($this->whereSeparator){
            $wsep = $this->whereSeparator;
            $this->whereSeparator = null;
        }else{
            $wsep = ' AND';
        }
        $count = $this->_this_where_count++;
        return empty($this->_where) ? ' WHERE' : $wsep;
    }

    private function _wrapperWhere($p1)
    {
        $a = explode('.', $p1);
        foreach($a as &$i){
            $i = '`' . $i . '`';
        }
        return implode('.', $a);
    }

    private function or()
    {
        $this->whereSeparator = ' OR';
        return $this;
    }

    private function where($p1, $p2 = null, $p3 = null)
    {

        $count = $this->_this_where_count++;
        $sep = $this->_separatorWhere();
        $pp1 = str_replace('.', '_', $p1) . '_' . $count;
        if (is_null($p2) && is_null($p3)) {
            $this->_where .= $sep . ' `' . $this->_id . '` = :' . $this->_id . ' ';
            $this->_bind[$this->_id] = $p1;
            $this->_data = array_merge([$this->_id => $p1]);
            $this->_idNumber = $p1;
        } elseif (is_null($p3)) {
            $this->_where .= $sep . ' ' . $this->_wrapperWhere($p1) . ' = :' . $pp1  . ' ';
            $this->_bind[$pp1] = $p2;
            $this->_data = array_merge([$p1 => $p2]);
            if ($p1 == $this->_id) {
                $this->_idNumber = $p2;
            }
        } else {
            $this->_where .= $sep . ' ' . $this->_wrapperWhere($p1) . ' ' . $p2 . ' :' . $pp1 . ' ';
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
        $sep = $this->_separatorWhere();
        $this->_where .= $sep . ' ' . $this->_wrapperWhere($p1) . ' IS NULL ';
        return $this;
    }

    private function whereNotNull(string $p1)
    {
        $sep = $this->_separatorWhere();
        $this->_where .= $sep . ' ' . $this->_wrapperWhere($p1) . ' IS NOT NULL ';
        return $this;
    }

    private function whereIn($p1, $arg)
    {
        $sep = $this->_separatorWhere();
        $arr = [];
        foreach ($arg as $i) {
            $count = $this->_this_where_count++;
            $pp1 = str_replace('.', '_', $p1) . '_' . $count;
            $this->_bind[$pp1] = $i;
            $arr[] = ':'.$pp1;
        }
        $str = implode(',', $arr);
        $this->_where .= $sep . ' ' . $this->_wrapperWhere($p1) . ' IN (' . $str . ')';
        return $this;
    }

    private function whereStr($str, $bind = [])
    {
        $this->_where .= $str;
        foreach ($bind as $key => $i) {
            $this->_bind[$key] = $i;
        }
        return $this;
    }

    private function whereAnd(callable $a)
    {
        $new = new \system\core\model\model();
        return $this;
    }
}