<?php
namespace app\filter;
use electronic\core\user\bruteforce as UserBruteforce;

class bruteforce
{
    public function index()
    {
        if(!empty($_POST)){
            $b = new UserBruteforce();
            if(!$b->status()){
                echo 'Временная блокировка. Осталось: '. $b->timeBlocked() . 'сек.' . PHP_EOL;
                exit('Blocked!');
            }else{
                $b->addTry();
            }
        }
    }
}