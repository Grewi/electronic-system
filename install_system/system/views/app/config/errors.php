<?php 
namespace app\configs;
!INDEX ? exit('exit') : true;

class errors
{

    public function set() : array
    {
        return [
            'display' => 1,
            'E_ERROR' => 1,
            'E_WARNING' => 1,
            'E_PARSE' => 1,
            'E_NOTICE' => 0,
            'E_CORE_ERROR' => 0,
            'E_CORE_WARNING' => 0,
            'E_COMPILE_ERROR' => 0,
            'E_COMPILE_WARNING' => 0,
            'E_USER_ERROR' => 0,
            'E_USER_WARNING' => 0,
            'E_USER_NOTICE' => 0,
            'E_STRICT' => 0,
            'E_RECOVERABLE_ERROR' => 0,
            'E_DEPRECATED' => 0,
            'E_USER_DEPRECATED' => 0,
            'E_ALL' => 0,
        ];
    }
}