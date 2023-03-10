<?php
namespace system\core\validate;

trait validetePassTrait
{
    public function pass()
    {
        $this->pass = $this->data[$this->currentName];
        return $this;
    }

    public function confirmPass()
    {
        if ($this->pass != $this->data[$this->currentName]) {
            $this->error[$this->currentName][] = lang('valid', 'confirmPass');
            $this->setControl(false);
        }
        return $this;
    }

    //Проверка текущего пароля
    //Значение
    //Имя таблицы
    //Имя ячейки
    //id строки
    public function currentPass($table, $col, $id)
    {
        $data = $this->data[$this->currentName];
        $user = db()->fetch('SELECT * FROM `' . $table . '` WHERE `id` = "' . $id . '"', []);
        if(isset($user->{$col})){
            $current = $user->{$col};
            if(!password_verify($data, $current)){
                
                $this->error[$this->currentName][] = lang('valid', 'currentPass');
                $this->setControl(false);
            }
        }else{
            $this->error[$this->currentName][] = lang('valid', 'noData');
            $this->setControl(false);
        }
        $this->setReturn(null);
        return $this;
    }
}