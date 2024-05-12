<?php
/**
 * Electronic v3.0
 * https://github.com/Grewi/electronic-system
 * grewi@ya.ru
 */

namespace system\core\cron;
use system\core\files\files;
use system\core\date\date;

!INDEX ? exit() : true;

class cron
{

    protected $name;
    protected $status = true;
    protected $first = false;
    protected $namespace;
    protected $log;
    protected $logFile = APP . '/cache/cron.json';

    public function namespace(string $name)
    {
        $this->namespace = $name;
        return $this;
    }

    public function name(string $name)
    {
        $this->status = true;
        $this->name = $name;
        $this->logFile();
        $this->controlTime();
        return $this;
    }    

    public function controller($class, $method = 'index')
    {
        if ($this->status && !$this->first) {
            $class = '\\' . files::pathR($this->namespace, $class);
            if(class_exists($class)){
                $controller = new $class();
                $controller->{$method}();
            }
        }
    }

    protected function logFile()
    {
        if (!file_exists($this->logFile)) {
            file_put_contents($this->logFile, '{}');
        }
        $this->log = json_decode(file_get_contents($this->logFile));
    }

    protected function controlTime()
    {
        if (!isset($this->log->{$this->name})) {
            $this->first = true;
            return;
        }

        if (!($this->log->{$this->name} <= time())) {
            $this->status = false;
            return;
        }
    }

    protected function logSave()
    {
        file_put_contents($this->logFile, json_encode($this->log));
    }

    /**
     * Считает время следующего испоолнения
     */
    protected function trueTime(int $i) : int
    {
        return empty($this->log->{$this->name}) || ($this->log->{$this->name} + $i) - time() <= 0
        ? time() + $i 
        : $this->log->{$this->name} + $i;
    }

    // Ежеминутно
    public function min(int $min = 1)
    {
        if ($this->status) {
            $t = $this->trueTime(60 * $min);
            $this->log->{$this->name} = $t;
            $this->logSave();
        }
        return $this;
    }

    // Каждый час
    public function hour(int $hour = 1)
    {
        if ($this->status) {
            $t = $this->trueTime(60 * 60 * $hour);
            $this->log->{$this->name} = $t;
            $this->logSave();
        }
        return $this;
    }

    // Ежедневно
    public function daily(int $hour)
    {
        if ($this->status) {
            $date = date::create(date('Y-m-d ' . ($hour > 9 ? $hour : '0' . $hour) . ':00', $this->trueTime(0)));
            $date->addDay(1);
            $this->log->{$this->name} = $date->format('U');
            $this->logSave();
        }
        return $this;
    }

    // Еженедельно
    public function weekly($day, $hour)
    {
        if ($this->status) {
            $date = date::create(date('Y-m-d ' . ($hour > 9 ? $hour : '0' . $hour) . ':00', $this->trueTime(0)));
            $date->dayWeekNext($day);
            $this->log->{$this->name} = $date->format('U');
            $this->logSave();
        }
        return $this;
    }

    // Ежемесячно
    public function monthly($day, $hour)
    {
        if ($this->status) {
            $d = date::create(date('Y-m-' . ($day > 9 ? $day : '0' . $day) . ' ' . ($hour > 9 ? $hour : '0' . $hour) . ':00', $this->trueTime(0)));
            if($d->format('U') < time()){
                $d->addMonth(1);
            }
            $this->log->{$this->name} = $d->format('U');
            $this->logSave();            
        }
        return $this;
    }
}
