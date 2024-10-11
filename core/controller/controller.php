<?php 

declare(strict_types = 1);

namespace system\core\controller;
use electronic\core\config\config;

!INDEX ? exit('exit') : true;

abstract class controller
{
    protected $data;
    protected $return;
    protected $siteUrl;
    
    protected function bc(string $name, string $url = '')
    {
        if(empty($this->data['bc'])){
            $this->data['bc'][] = ['name' => lang('global', 'home'), 'url' => '/'];
        }
        $this->data['bc'][] = ['name' => $name, 'url' => $url];
    }

    protected function alert()
    {
        if ( isset($_SESSION['alert']) ) {
            $this->return->alert->set($_SESSION['alert']);
            unset($_SESSION['alert']);
        } else {
            $this->data['alert'] = [];
        }
    }

    protected function data()
    {
        if(isset($_SESSION['data'])){
            foreach($_SESSION['data'] as $k => $i){
                $this->return->data->set([$k => $i]);
            }
            unset($_SESSION['data']);
        }
    }

    protected function error()
    {
        if (isset($_SESSION['error'])) {
            foreach ($_SESSION['error'] as $k => $i) {
                $this->return->error->set([$k => $i]);
                $this->return->class->set([$k => 'is-invalid']);
            }
            unset($_SESSION['error']);
        }
    }

    protected function title(string $title = '')
    {
        $configTitle = config::globals('title');
        $sep = ' | ';
        if(!empty($title)){
            $this->data['title'] = $title . $sep . $configTitle;
        }else{
            $this->data['title'] = $configTitle;
        }
    }

    protected function return($data = null)
    {
        if(is_object($data)){
            foreach($data as $a => $i){
                if(empty( $this->data['return']->data->{$a})){
                    $this->data['return']->data->set([$a => $i]);
                }
            }
        }
    }

    protected function views($key, $value)
    {
        $app = \system\core\app\app::app();
        $app->views->set([$key => $value]);
    }
}