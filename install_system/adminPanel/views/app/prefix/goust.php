<?php 
namespace app\prefix;
use app\controllers\error\error;

class goust
{
    public function index()
    {
        if(user_id()){
            return false;
        }
    }
}