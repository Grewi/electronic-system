<?php 
namespace app\prefix;
use app\controllers\error\error;

class user
{
    public function index()
    {
        if(!user_id()){
            return false;
        }
    }
}