<?php

if (!function_exists('dateTimeParse')) {
    function dateTimeParse($dateTime)
    {
        $ar = explode(' ', $dateTime);
        $date = isset($ar[0]) ? explode('-', $ar[0]) : ['0', '0', '0'];
        $time = isset($ar[1]) ? explode(':', $ar[1]) : ['0', '0', '0'];
        return [
            'day' => $date[2],
            'month' => $date[1],
            'year' => $date[0],
            'hour' => $time[0],
            'min' => $time[1],
            'sec' => $time[2],
        ];
    }
}

if (!function_exists('monthLangR')) {
    function monthLangR($month)
    {
        $month = (int)$month;
        $arr = [
            1 => 'января',
            2 => 'февраля',
            3 => 'марта',
            4 => 'апреля',
            5 => 'мая',
            6 => 'июня',
            7 => 'июля',
            8 => 'августа',
            9 => 'сентября',
            10 => 'октября',
            11 => 'ноября',
            12 => 'декабря',
        ];
        return isset($arr[$month]) ? $arr[$month] : '';
    }
}

if (!function_exists('monthLangI')) {
    function monthLangI($month)
    {
        $arr = [
            1 => 'январь',
            2 => 'февраль',
            3 => 'март',
            4 => 'апрель',
            5 => 'май',
            6 => 'июнь',
            7 => 'июль',
            8 => 'август',
            9 => 'сентябрь',
            10 => 'октябрь',
            11 => 'ноябрь',
            12 => 'декабрь',
        ];
        return isset($arr[(int)$month]) ? $arr[(int)$month] : '';
    }
}

if (!function_exists('weekLandgI')) {
    function weekLandgI($day)
    {
        $arr = [
            1 => 'Понедельник',
            2 => 'Вторник',
            3 => 'Среда',
            4 => 'Четверг',
            5 => 'Пятница',
            6 => 'Суббота',
            7 => 'Воскресение',
        ];
        return isset($arr[(int)$day]) ? $arr[(int)$day] : '';
    }
}

if (!function_exists('eDateValid')) {
    function eDateValid($year, $month, $day)
    {
        return checkdate((int)$month, (int)$day, (int)$year);
    }
}

if (!function_exists('eDate')) {
    function eDate($date, $mask = 'd.m.Y')
    {
        if (!$date) return;
        $d = \system\core\date\date::create($date);
        return $d->format($mask);
    }
}

if (!function_exists('eDateLang')) {
    function eDateLang($date, $p = 'r')
    {
        if (!$date) return;
        $d = \system\core\date\date::create($date);
        return $d->formatLang($p);
    }
}

if (!function_exists('eTime')) {
    function eTime($date, $mask = 'H:i')
    {
        if (!$date) return;
        $d = \system\core\date\date::create($date);
        return $d->format($mask);
    }
}

if (!function_exists('eDateTime')) {
    function eDateTime($date, $mask = 'd.m.Y h:i')
    {
        if (!$date) return;
        $d = \system\core\date\date::create($date);
        return $d->format($mask);
    }
}

if (!function_exists('addDay')) {
    function addDay($date, $count = 1, $format = 'Y-m-d')
    {
        if (!$date) return;
        $d = \system\core\date\date::create($date);
        $d->addDay($count);
        return $d->format($format);
    }
}

if (!function_exists('subDay')) {
    function subDay($date, $count = 1, $format = 'Y-m-d')
    {
        if (!$date) return;
        $d = \system\core\date\date::create($date);
        $d->subDay($count);
        return $d->format($format);
    }
}

if (!function_exists('addWeek')) {
    function addWeek($date, $count = 1, $format = 'Y-m-d')
    {
        if (!$date) return;
        $d = \system\core\date\date::create($date);
        $d->addWeek($count);
        return $d->format($format);
    }
}

if (!function_exists('subWeek')) {
    function subWeek($date, $count = 1, $format = 'Y-m-d')
    {
        if (!$date) return;
        $d = \system\core\date\date::create($date);
        $d->subWeek($count);
        return $d->format($format);
    }
}

if (!function_exists('addMonth')) {
    function addMonth($date, $count = 1, $format = 'Y-m-d')
    {
        if (!$date) return;
        $d = \system\core\date\date::create($date);
        $d->addMonth($count);
        return $d->format($format);
    }
}

if (!function_exists('subMonth')) {
    function subMonth($date, $count = 1, $format = 'Y-m-d')
    {
        if (!$date) return;
        $d = \system\core\date\date::create($date);
        $d->subMonth($count);
        return $d->format($format);
    }
}

if (!function_exists('addYear')) {
    function addYear($date, $count = 1, $format = 'Y-m-d')
    {
        if (!$date) return;
        $d = \system\core\date\date::create($date);
        $d->addYear($count);
        return $d->format($format);
    }
}

if (!function_exists('subYaer')) {
    function subYaer($date, $count = 1, $format = 'Y-m-d')
    {
        if (!$date) return;
        $d = \system\core\date\date::create($date);
        $d->subYaer($count);
        return $d->format($format);
    }
}

if (!function_exists('addHour')) {
    function addHour($date, $count = 1, $format = 'H:i')
    {
        if (!$date) return;
        $d = \system\core\date\date::create($date);
        $d->addInterval('PT' . $count . 'H');
        return $d->format($format);
    }
}

if (!function_exists('subHour')) {
    function subHour($date, $count = 1, $format = 'H:i')
    {
        if (!$date) return;
        $d = \system\core\date\date::create($date);
        $d->subInterval('PT' . $count . 'H');
        return $d->format($format);
    }
}

if (!function_exists('addMin')) {
    function addMin($date, $count = 1, $format = 'H:i')
    {
        if (!$date) return;
        $d = \system\core\date\date::create($date);
        $d->addInterval('PT' . $count . 'M');
        return $d->format($format);
    }
}

if (!function_exists('subMin')) {
    function subMin($date, $count = 1, $format = 'H:i')
    {
        if (!$date) return;
        $d = \system\core\date\date::create($date);
        $d->subInterval('PT' . $count . 'M');
        return $d->format($format);
    }
}

if (!function_exists('intervalDay')) {
    function intervalDay($date1, $date2 = null)
    {
        $date2 = $date2 ? $date2 : date('Y-m-d H:i');
        $d = \system\core\date\date::create($date1);
        return $d->intervalDay($date1, $date2);
    }
}
