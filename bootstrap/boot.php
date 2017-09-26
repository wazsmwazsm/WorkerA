<?php

use WorkerF\Config;

// autoload
require_once __DIR__ . '/../vendor/autoload.php';

// load config
$configs = preg_grep('/.*\.php$/', scandir(__DIR__ . '/../config'));

foreach ($configs as $config) {
    Config::set(basename($config, '.php'), (require_once __DIR__ . '/../config/'. $config));
}

// set timezone
date_default_timezone_set(Config::get('app.timezone'));

// routers
require_once __DIR__ . '/../routes/test.php';
