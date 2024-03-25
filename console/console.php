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

$route->console('clean')->controller('clean', 'index');
$route->console('clean/cache')->controller('clean', 'cleanCache');

$route->console('create/dump')->controller('database', 'createDump');
$route->console('restore/dump')->controller('database', 'restoreDump');
$route->console('drop/tables')->controller('database', 'dropTables');

//Config
$route->console('create/config')->controller('createConfig', 'index');
$route->console('create/config/ini')->controller('createConfigIni', 'index');
$route->console('clean/config')->controller('clean', 'cleanConfig');
$route->console('config')->controller('config', 'actual');

$route->console('create/symlink')->controller('createSymlink', 'index');

$route->console('style')->controller('sass', 'compile');
$route->console('style/info')->controller('sass', 'info');

$route->console('help')->controller('help', 'index');

require_once ROOT . '/app/route/console.php';


exit('no controller ');
