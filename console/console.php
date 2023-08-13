<?php

use system\core\route\route;

$route = new route();

$route->namespace('system/console');

$route->console('update/system')->controller('updateSystem', 'index')->exit();
$route->console('add/complement')->controller('addComplement', 'index');

$route->console('create/controller')->controller('createController', 'index')->exit();
$route->console('create/model')->controller('createModel', 'index')->exit();

$route->console('migrate')->controller('migrate', 'index')->exit();
$route->console('create/migration')->controller('migrate', 'createMigration')->exit();

$route->console('clean')->controller('clean', 'index')->exit();
$route->console('clean/cache')->controller('clean', 'cleanCache')->exit();

$route->console('create/dump')->controller('database', 'createDump')->exit();
$route->console('restore/dump')->controller('database', 'restoreDump')->exit();
$route->console('drop/tables')->controller('database', 'dropTables')->exit();

//Config
$route->console('create/config')->controller('createConfig', 'index')->exit();
$route->console('create/config/ini')->controller('createConfigIni', 'index')->exit();
$route->console('clean/config')->controller('clean', 'cleanConfig')->exit();

$route->console('config')->controller('config', 'actual')->exit();

$route->console('help')->controller('help', 'index')->exit();

require_once ROOT . '/app/route/console.php';


exit('no controller ');
