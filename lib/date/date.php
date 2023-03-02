<?php

namespace system\lib\date;

class date
{
    //Переформатирование даты по-человечески
    public static function reformat_Date($dateseminar, $date_normal)
    {
        $dateseminar = explode('-', $dateseminar);
        $date_normal = "$dateseminar[2]-$dateseminar[1]-$dateseminar[0]";
        return $date_normal;
    }

    //Получаем название месяца и года прописью
    public static function getNameMes($mes_f, $name_mes)
    {
        switch ($mes_f) {
            case "01":
                $name_mes = "январь";
                break;

            case "02":
                $name_mes = "февраль";
                break;

            case "03":
                $name_mes = "март";
                break;

            case "04":
                $name_mes = "апрель";
                break;

            case "05":
                $name_mes = "май";
                break;

            case "06":
                $name_mes = "июнь";
                break;

            case "07":
                $name_mes = "июль";
                break;

            case "08":
                $name_mes = "август";
                break;

            case "09":
                $name_mes = "сентябрь";
                break;

            case "10":
                $name_mes = "октябрь";
                break;

            case "11":
                $name_mes = "ноябрь";
                break;

            case "12":
                $name_mes = "декабрь";
                break;

            default:
                $name_mes = "не установлено";
                break;
        }
        return $name_mes;
    }

    public static function monthList() : array
    {
        return [
            1 =>'Январь', 
            2 =>'Февраль', 
            3 =>'Март', 
            4 =>'Апрель', 
            5 =>'Май', 
            6 =>'Июнь', 
            7 => 'Июль', 
            8 => 'Август', 
            9 => 'Сентябрь', 
            10 => 'Октябрь', 
            11 => 'Ноябрь', 
            12 => 'Декабрь',
        ];
    }

    public static function dayWeek()
    {
        return [
            1 =>'Понедельник', 
            2 =>'Вторник', 
            3 =>'Среда', 
            4 =>'Четверг', 
            5 =>'Пятница', 
            6 =>'Суббота', 
            7 => 'Воскресение', 
        ];
    }

    public static function monthQuarter()
    {
        return [
            1 => 'Первый месяц квартала', 
            2 => 'Второй месяц квартала', 
            3 => 'Третий месяц квартала',
        ];
    }
}
