<?php 
namespace system\core\user;
use system\core\traits\singleton;

class bruteforce
{
    private $firstTry;
    private $firstTime;
    private $timeTry;
    private $sessionName;
    private $timeOutTry;

    /**
     * $firstTry  - Количество попыток
     * $firstTime - Время блокировки
     * $timeTry   - Максимальное время между запросами, иначе сброс счётчика
     */
    public function __construct($firstTry = 5, $firstTime = 60, $timeTry = 60, $sessionName = 'bruteforce')
    {
        $this->firstTry = $firstTry;
        $this->firstTime = $firstTime;
        $this->timeTry = $timeTry;
        $this->sessionName = $sessionName;
        $this->timeOutTry = time();
    }

    //Регистрация попытки
    public function addTry():void
    {
        if(time() - $this->timeOutTry > $this->timeTry){
            $this->resetTry();
            return;
        }
        $try = isset($_SESSION[$this->sessionName]['count']) ? $_SESSION[$this->sessionName]['count'] : 0;
        $_SESSION[$this->sessionName]['count'] = ++$try;
        if($this->remain() < 1){
            $this->resetTry();
            $this->blocking();
        }
    }

    //Сброс счётчика попыток
    public function resetTry():void
    {
        $_SESSION[$this->sessionName]['count'] = 0;
    }

    //Остаток попыток
    public function remain():int
    {
        $i = $this->firstTry - $_SESSION[$this->sessionName]['count'];
        return $i < 1 ? 0 : $i;
    }

    //Блокировка
    public function blocking():void
    {
        $_SESSION[$this->sessionName]['block']['status'] = true;
        $_SESSION[$this->sessionName]['block']['time'] = time();
    }

    //Статус
    public function status():bool
    {
        if(isset($_SESSION[$this->sessionName]['block']) ){
            if($this->timeBlocked() > 0){
                return false;
            }else{
                return true;
            }
        }else{
            return true;
        }
    }

    //Остаток времени блокировки
    public function timeBlocked():int
    {
        if(isset($_SESSION[$this->sessionName]['block']['time'])){
            $i = $_SESSION[$this->sessionName]['block']['time'] + $this->firstTime;
            if($i < time()){
                unset($_SESSION[$this->sessionName]['block']);
                return 0;
            }else{
                return $i - time();
            }
        }else{
            return 0;
        }
    }
}