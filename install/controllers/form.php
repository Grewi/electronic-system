<?php 
namespace system\install\controllers;
use system\install\view\view;

class form
{
    public static function index()
    {
        new view('index', []);
    }
}