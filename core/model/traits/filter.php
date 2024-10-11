<?php
namespace system\core\model\traits;

trait filter
{
    /**
     * Обработка get параметров filter_* Поиск совпадений в столбце по запросу
     * @param string $name - наименование get параметра 
     * @param string $col - наименование столбца в таблице, если не указан, то равен параметру name
     * @return mixed
     */
    protected function filterLike(string $name, string $col = null): self
    {
        $col = $col ? $col : $name;
        if (isset($_GET['filter_' . $name]) && $_GET['filter_' . $name] != '') {
            $this->whereLike($col, $_GET['filter_' . $name]);
        }
        return $this;
    }

    /**
     * Обработка массива get параметров filter_* Поиск совпадений в нескольких столбцах по запросу
     * @param string $name - наименование get параметра 
     * @param string $col - наименование столбца в таблице, если не указан, то равен параметру name
     * @return mixed
     */
    protected function filterLikeMulty(string $name, array $cols): self
    {
        if (isset($_GET['filter_' . $name]) && $_GET['filter_' . $name] != '') {
            $r = ' ' . $this->_separatorWhere() . ' (';
            $c = 0;
            foreach ($cols as $col) {
                ++$c;
                $col = $col ? $col : $name;
                $count = $this->_this_where_count++;
                $colb = str_replace('.', '_', $col) . '_' . $count;
                $this->_bind[$colb] = $_GET['filter_' . $name];            
                $r .= ' ' . $this->_wrapperWhere($col) . ' LIKE CONCAT("%", :' . $colb . ',"%") ';
                if ($c < count($cols)) {
                    $r .= ' OR ';
                }
            }
            $r .= ') ';
            $this->_where .= $r;
        }
        // dd($this->_bind);
        return $this;
    }

    /**
     * Обработка get параметров filter_*[min] и filter_*[max] для обработки диапазона параметров
     * @param string $name - наименование столбца в таблице
     * @return mixed
     */
    protected function filterRange(string $name): self
    {
        if (isset($_GET['filter_' . $name])) {

            if (isset($_GET['filter_' . $name]['min']) && !empty($_GET['filter_' . $name]['min'])) {
                $this->where($name, '>=', $_GET['filter_' . $name]['min']);
            }

            if (isset($_GET['filter_' . $name]['max']) && !empty($_GET['filter_' . $name]['max'])) {
                $this->where($name, '<=', $_GET['filter_' . $name]['max']);
            }
        }
        return $this;
    }
}