<?php 
namespace app\controllers\generatorPage;

use app\models\page_generator;
use app\models\data_page_generator;
use app\controllers\controller;
use electronic\core\view\view;
use electronic\core\route\route;
use app\controllers\error\error;

class pageController extends controller
{
    public function index()
    {
        $url = implode('/', (new route())->getUrl());
        $page = page_generator::where('url', $url)->get();
        if(!$page){
            (new error())->error404();
            exit();
        }
        $data = data_page_generator::where('page_id', $page->id)->all();
        if(is_iterable($data)){
            foreach($data as $d){
                if($d->type == 2 ||$d->type == 1){
                    $this->data[$d->name] = json_decode($d->data);
                }
                if($d->type == 3){
                    $this->data[$d->name] = json_decode($d->data);
                }
            }
        }
        if($page->title){
            $this->title($page->title);
        }
        new view('generatorPage/' . $page->url, $this->data);
    }
}
