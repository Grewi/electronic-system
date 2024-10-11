<?php
namespace app\controllers\admin;

class controller extends \app\controllers\controller
{
    protected function bc(string $name, string $url = '')
    {
        if(empty($this->data['bc'])){
            $this->data['bc'][] = ['name' => lang('admin', 'home'), 'url' => '/'];
            $this->data['bc'][] = ['name' => lang('admin', 'admin'), 'url' => '/' . ADMIN];
        }
        $this->data['bc'][] = ['name' => $name, 'url' => $url];
    }
}