<?php 
namespace app\configs;
!INDEX ? exit('exit') : true;

class database
{

    public function set() : array
    {
        return [
            'type' => '{{$type}}',
            'name' => '{{$name}}',
            'user' => '{{$user}}',
            'pass' => '{{$pass}}',
            'host' => '{{$host}}',
            'file_name' => '{{$file}}',
        ];
    }
}