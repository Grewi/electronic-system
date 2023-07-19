<?php 
namespace system\install_system\controllers;
use system\install\view\view;

class form
{
    public static function index()
    {
        new view('index', []);
    }
}