<?php
//https://www.php.net/manual/ru/dateinterval.construct.php
//https://www.php.net/manual/ru/datetime.formats.php
namespace system\core\date;

class date
{
    private static $connect;
    private $dateTime;
    private $dayWeek = [
        1 => 'monday',
        2 => 'tuesday',
        3 => 'wednesday',
        4 => 'thursday',
        5 => 'friday',
        6 => 'saturday',
        7 => 'sunday'
    ];

    private function __construct($dateTime)
    {
        try {
            $this->dateTime = new \DateTime($dateTime);
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public static function monthLangR($month)
    {
        $arr = [
            1  => 'января',
            2  => 'февраля',
            3  => 'марта',
            4  => 'апреля',
            5  => 'мая',
            6  => 'июня',
            7  => 'июля',
            8  => 'августа',
            9  => 'сентября',
            10 => 'октября',
            11 => 'ноября',
            12 => 'декабря',
        ];
        return isset($arr[$month]) ? $arr[$month] : '';
    }

    public static function monthLangI($month)
    {
        $arr = [
            1  => 'январь',
            2  => 'февраль',
            3  => 'март',
            4  => 'апрель',
            5  => 'май',
            6  => 'июнь',
            7  => 'июль',
            8  => 'август',
            9  => 'сентябрь',
            10 => 'октябрь',
            11 => 'ноябрь',
            12 => 'декабрь',
        ];
        return isset($arr[(int)$month]) ? $arr[(int)$month] : '';
    }

    public static function weekLandgI($day)
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

    public static function create($dateTime)
    {
        self::$connect = new self($dateTime);
        return self::$connect;
    }

    //Произвольный интервал
    public function addInterval($interval)
    {
        $interval = new \DateInterval($interval);
        $this->dateTime->add($interval);
        return $this;
    }

    public function subInterval($interval)
    {
        $interval = new \DateInterval($interval);
        $this->dateTime->sub($interval);
        return $this;
    }

    //Минуты
    public function addMin($time)
    {
        $interval = new \DateInterval('PT' . $time . 'M');
        $this->dateTime->add($interval);
        return $this;
    }

    public function subMin($time)
    {
        $interval = new \DateInterval('PT' . $time . 'M');
        $this->dateTime->sub($interval);
        return $this;
    }

    //Часы
    public function addHorse($time)
    {
        $interval = new \DateInterval('PT' . $time . 'H');
        $this->dateTime->add($interval);
        return $this;
    }

    public function subHorse($time)
    {
        $interval = new \DateInterval('PT' . $time . 'H');
        $this->dateTime->sub($interval);
        return $this;
    }


    //Дни
    public function addDay($day)
    {
        $interval = new \DateInterval('P' . $day . 'D');
        $this->dateTime->add($interval);
        return $this;
    }

    public function subDay($day)
    {
        $interval = new \DateInterval('P' . $day . 'D');
        $this->dateTime->sub($interval);
        return $this;
    }

    //Недели
    public function addWeek($week)
    {
        $interval = new \DateInterval('P' . $week . 'W');
        $this->dateTime->add($interval);
        return $this;
    }

    //Ближайший следующий день недели
    public function dayWeekNext($day)
    {
        $interval = new \DateInterval($this->dayWeek[$day] . ' next week');
        $this->dateTime->add($interval);
        return $this;
    }

    //Ближайший предыдущий день недели
    public function dayWeekPrev($day)
    {
        $interval = new \DateInterval($this->dayWeek[$day] . ' previous week');
        $this->dateTime->add($interval);
        return $this;
    }

    public function subWeek($week)
    {
        $interval = new \DateInterval('P' . $week . 'W');
        $this->dateTime->sub($interval);
        return $this;
    }

    //Месяцы
    public function addMonth($month)
    {
        $interval = new \DateInterval('P' . $month . 'M');
        $this->dateTime->add($interval);
        return $this;
    }

    public function subMonth($month)
    {
        $interval = new \DateInterval('P' . $month . 'M');
        $this->dateTime->sub($interval);
        return $this;
    }

    //Год
    public function addYear($year)
    {
        $interval = new \DateInterval('P' . $year . 'Y');
        $this->dateTime->add($interval);
        return $this;
    }

    public function subYaer($year)
    {
        $interval = new \DateInterval('P' . $year . 'Y');
        $this->dateTime->sub($interval);
        return $this;
    }

    //Формат
    public function format($format)
    {
        return $this->dateTime->format($format);
    }

    //Дата прописью в именительном и родительном падежах
    public function formatLang($p = 'i')
    {
        $Y = $this->dateTime->format('Y');
        if ($p == 'i') {
            $m = $this->monthLangI((int)$this->dateTime->format('m'));
        }
        if ($p == 'r') {
            $m = $this->monthLangR((int)$this->dateTime->format('m'));
        }
        $d = (int)$this->dateTime->format('d');
        return $this->dateTime->format($d . ' ' . $m . ' ' . $Y);
    }

    //Месяц прописью в именительном и родительном падежах
    public function monthFormatLang($p = 'i')
    {
        if ($p == 'i') {
            return $this->monthLangI((int)$this->dateTime->format('m'));
        }
        if ($p == 'r') {
            return $this->monthLangR((int)$this->dateTime->format('m'));
        }
    }

    public function intervalDay($date1, $date2)
    {
        $origin = new \DateTimeImmutable($date1);
        $target = new \DateTimeImmutable($date2);
        $interval = $target->diff($origin);
        return $interval->format('%R%a') < 0 ? 0 : $interval->format('%a');
    }

    public static function dateTimeParse($dateTime)
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
