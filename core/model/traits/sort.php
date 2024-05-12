<?php
namespace system\core\model\traits;

trait sort
{
    protected function sorting()
    {
        if(!isset($_GET['sort']) || !in_array($_GET['sort'], $this->_sortName)){
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

    public function sortLink($name, $lang)
    {
        $href = eGetReplace('sort', $name);
        if($_GET['sort'] == $name){
            if($_GET['direction'] == 'desc'){
                $hrefD = eGetReplace('direction', 'asc');
                $iconD = $this->_sortIconDesc;
            }else{
                $hrefD = eGetReplace('direction', 'desc');
                $iconD = $this->_sorIconAsc;
            }
        }

        if($_GET['sort'] == $name){
            return '<a href="' . $hrefD . '">' . $lang . '</a>' . $iconD;
        }else{
            return '<a href="' . $href . '">' . $lang . '</a>';
        } 
    }
}