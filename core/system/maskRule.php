<?php

namespace system\core\system;

class maskRule
{
    private string $rules;
    private $mask = [
        '0' => '0000',
        '1' => '0001',
        '2' => '0010',
        '3' => '0011',
        '4' => '0100',
        '5' => '0101',
        '6' => '0110',
        '7' => '0111',
        '8' => '1000',
        '9' => '1001',
        'a' => '1010',
        'b' => '1011',
        'c' => '1100',
        'd' => '1101',
        'e' => '1110',
        'f' => '1111',
        ];

    public function __construct($rules)
    {
        $this->rules = mb_strtolower($rules);
    }

    //Возвращает маску прав
    public function getRules()
    {
        return $this->rules;
    }

    //Возвращает значение по номеру
    public function getRule(int $number) : bool
    {
        if($number < 1){
            throw new \GlobalException('Номер правила не может быть меньше единицы');
        }
        $a = $number/4;
        $b = $number%4;
        $c = floor($b==0?$a-1:$a);
        $d = $this->rules[$c];
        $mask = $this->mask[$d];
        return $mask[$this->numberInMask($b)] == 1 ? true : false;
    }

    //Устанавливает значение по номеру
    public function setRule(int $number, bool $value):void
    {
        if($number < 1){
            throw new \GlobalException('Номер правила не может быть меньше единицы');
        }
        $a = $number/4;
        $b = $number%4;
        $c = floor($b==0?$a-1:$a);
        $d = $this->rules[$c];
        $mask = $this->mask[$d];
        $r = $mask[$this->numberInMask($b)] == 1 ? true : false;

        //Если значение не меняется выходим
        if($r == $value){
            return;
        }
        $mask[$this->numberInMask($b)] = $value ? '1' : '0';

        //Новый литерал
        $this->rules[$c] = array_search($mask, $this->mask);
    }

    private function numberInMask($b)
    {
        return match($b){
            1 => 0,
            2 => 1,
            3 => 2,
            0 => 3,
        };
    }


}