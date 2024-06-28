<?php 
namespace route\crone;
use system\core\cron\cron;


$cron = new cron();
$cron->namespace('system/console');

// $cron->name('test')->quarter()->controller('test', 'index');

print('cron') . PHP_EOL;