<?php

namespace app\models;
use app\models\blogs;
use electronic\core\model\model;

class blogs_categories extends model
{
    private $bcArray = [];
    private $treeArray = [];

    protected function bc($parent_id = null, $revers = false)
    {
        $el = blogs_categories::find($parent_id ?? 0);
        if ($el) {
            $this->bcArray[] = $el;
        }

        if ($el->parent_id) {
            $this->bc($el->parent_id);
        }

        if ($revers) {
            return array_reverse($this->bcArray);
        } else {
            return $this->bcArray;
        }
    }


    protected function tree($id = null)
    {
        if ($id) {
            $arr = db()->fetchAll('SELECT * FROM `blogs_categories` WHERE `parent_id` = :p  ORDER BY sort ASC', ['p' => $id], __CLASS__);
        } else {
            $arr = db()->fetchAll('SELECT * FROM `blogs_categories` WHERE `parent_id` IS NULL  ORDER BY sort ASC', [], __CLASS__);
        }
        foreach ($arr as &$i) {
            $i->children = $this->tree($i->id);
        }

        return $arr;
    }

    protected function treeArray($id = null)
    {
        $a = [];
        if ($id) {
            $a[] = $id;
            $arr = db()->fetchAll('SELECT * FROM `blogs_categories` WHERE `parent_id` = :p ORDER BY sort ASC', ['p' => $id], __CLASS__);
        } else {
            $arr = db()->fetchAll('SELECT * FROM `blogs_categories` WHERE `parent_id` IS NULL  ORDER BY sort ASC', [], __CLASS__);
        }
        
        foreach ($arr as $i) {
            $a[] = $i->id;
            $ar = $this->treeArray($i->id);
            $a = array_merge($ar, $a);
        }
        return $a;
    }
}
