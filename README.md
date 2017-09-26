# WorkerA

[中文文档](https://github.com/wazsmwazsm/WorkerA/blob/master/README_CN.md  "中文文档")

[framework part](https://github.com/wazsmwazsm/WorkerF  "framework part")

## About

  a http framework for workerman

  - memory-resident
  - multiprocess, Highly concurrent
  - singleton db connection
  - use dependency injection
  - brief routing
  - support mysql driver, timeout auto reconnect

  Not allround but brief, Extensible, efficient

## Requires

  PHP 5.4 or Higher
  A POSIX compatible operating system (Linux, OSX, BSD)
  POSIX extensions for PHP
  PCNTL extensions for PHP
  PDO extensions for PHP
  PDO_MYSQL extensions for PHP

  For better concurrency :
      EVENT or LIBEVENT extensions for PHP

  For Https :
      OPENSSL extensions for PHP

## How to use?

### install

  composer create-project wazsmwazsm/workera your-project-name --prefer-dist

### use

#### directory structure
  - config/ : configuration file
  - app/Controller/ : your controller file
  - app/Models/ : your model file
  - routes/ : your route file
  - WorkerStart.php : startup file

#### run http mode
  sudo php WorkerStart.php start -d

#### run https mode
  modify HttpsStart.php, replace local_cert \ local_pk to your own certificate
  sudo php HttpsStart.php start -d

#### create route, just like laravel
```php
<?php
// must require
use Framework\Http\Route;

// normol
Route::get('/a/b', function() {
    echo 'a';
});

Route::post('/a/b', function() {
    echo 'a';
});

......

// controller@method
Route::get('/', "App\Controller\TestController@test");

// group, support path prefix and namespace prefix
Route::group(['prefix' => '/pre', 'namespace' => 'App\Controller'], function() {
    Route::get('control/', 'TestController@test');
    Route::post('call1/', function() {
        return 'hello1';
    });
    Route::get('call2/', function() {
        return 'hello2';
    });
});

```

how to load a new route you created ?

just open bootstrap/boot.php append  
```php
<?php
  require_once __DIR__ . '/../routes/newroute.php';

```


## Dependents
  [workerman](http://www.workerman.net/ "workerman")

## License

The WorkerA is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
