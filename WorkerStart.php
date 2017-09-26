<?php

require_once __DIR__ . '/bootstrap/boot.php';
use Workerman\Worker;
use WorkerF\App;

// echo error message on daemon mode
Worker::$stdoutFile = './tmp/log/error.log';
Worker::$logFile = './tmp/log/workerman.log';

$http_worker = new Worker('http://0.0.0.0:80');
$http_worker->count = 4;
$http_worker->user = 'www-data';

$http_worker->onWorkerStart = function($http_worker) {
    // init db connection
    App::dbInit();
};

$http_worker->onMessage = function($con, $data) {
    // run web app
    App::run($con);
};

Worker::runAll();
