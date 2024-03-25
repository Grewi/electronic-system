<?php
namespace system\core\validate;
use system\core\user\register;

trait validetePassTrait
{
    public function pass()
    {
        $this->pass = $this->data[$this->currentName];
        $this->setReturn(register::password($this->pass));
        return $this;
    }

    public function confirmPass()
    {
        $errorText = $this->errorText ? $this->errorText : lang('valid', 'confirmPass');
        if ($this->pass != $this->data[$this->currentName]) {
            $this->error[$this->currentName][] = $errorText;
            $this->setControl(false);
        }
        return $this;
    }

    //Проверка текущего пароля
    //Значение
    //Имя таблицы
    //Имя ячейки
    //id строки
    public function currentPass(string $table, string $col, $id)
    {
        $data = $this->data[$this->currentName];
        $user = db()->fetch('SELECT * FROM `' . $table . '` WHERE `id` = "' . $id . '"', []);
        if(isset($user->{$col})){
            $errorText = $this->errorText ? $this->errorText : lang('valid', 'currentPass');
            $current = $user->{$col};
            if(!password_verify($data, $current)){
                
                $this->error[$this->currentName][] = $errorText;
                $this->setControl(false);
            }
        }else{
            $errorText = $this->errorText ? $this->errorText : lang('valid', 'noData');
            $this->error[$this->currentName][] = $errorText;
            $this->setControl(false);
        }
        $this->setReturn(null);
        return $this;
    }
}