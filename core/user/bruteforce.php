<?php 
namespace system\core\user;
use system\core\traits\singleton;

class bruteforce
{
    private $firstTry = 5;
    private $firstTime = 60 * 1;

    //Регистрация попытки
    public function addTry():void
    {
        $try = isset($_SESSION['bruteforce']['count']) ? $_SESSION['bruteforce']['count'] : 0;
        $_SESSION['bruteforce']['count'] = ++$try;
        if($this->remain() < 1){
            $this->resetTry();
            $this->blocking();
        }
    }

    //Сброс счётчика попыток
    public function resetTry():void
    {
        $_SESSION['bruteforce']['count'] = 0;
    }

    //Остаток попыток
    public function remain():int
    {
        $i = $this->firstTry - $_SESSION['bruteforce']['count'];
        return $i < 1 ? 0 : $i;
    }

    //Блокировка
    public function blocking():void
    {
        $_SESSION['bruteforce']['block']['status'] = true;
        $_SESSION['bruteforce']['block']['time'] = time();
    }

    //Статус
    public function status():bool
    {
        if(isset($_SESSION['bruteforce']['block']) ){
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
        if(isset($_SESSION['bruteforce']['block']['time'])){
            $i = $_SESSION['bruteforce']['block']['time'] + $this->firstTime;
            if($i < time()){
                unset($_SESSION['bruteforce']['block']);
                return 0;
            }else{
                return $i - time();
            }
        }else{
            return 0;
        }
    }
}