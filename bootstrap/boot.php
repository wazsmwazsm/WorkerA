<?php

use WorkerF\Config;
use WorkerF\IOCContainer;

require_once __DIR__ . '/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Load config
|--------------------------------------------------------------------------
| 
| load all configuration from config dir
|
*/
$configs = preg_grep('/.*\.php$/', scandir(__DIR__ . '/../config'));

foreach ($configs as $config) {
    Config::load(basename($config, '.php'), (require_once __DIR__ . '/../config/'. $config));
}

/*
|--------------------------------------------------------------------------
| Set timezone
|--------------------------------------------------------------------------
| 
| Set your application timezone
|
*/
date_default_timezone_set(Config::get('app.timezone'));

/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| load all route file from routes dir
|
*/
require_once __DIR__ . '/../routes/app.php';

/*
|--------------------------------------------------------------------------
| Register class
|--------------------------------------------------------------------------
|
| These classes will be instantiate, set to singletons
|
*/

// set exception handler
IOCContainer::register(
    WorkerF\Exceptions\ExceptionHandler::class, 
    App\Exceptions\Handler::class
);

