<?php
use system\core\date\date;

if (!function_exists('dateTimeParse')) {
    function dateTimeParse($dateTime)
    {
        return date::dateTimeParse($dateTime);
    }
}

if (!function_exists('monthLangR')) {
    function monthLangR($month)
    {
        return date::monthLangR($month);
    }
}

if (!function_exists('monthLangI')) {
    function monthLangI($month)
    {
        return date::monthLangI($month);
    }
}

if (!function_exists('weekLandgI')) {
    function weekLandgI($day)
    {
        return date::weekLandgI($day);
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
