# WorkerA

[中文文档](https://github.com/wazsmwazsm/WorkerA/blob/master/README_CN.md  "中文文档")

[framework part](https://github.com/wazsmwazsm/WorkerF  "framework part")

## About

  a http framework for [workerman](http://www.workerman.net/ "workerman")

  - memory-resident
  - multiprocess, Highly concurrent
  - singleton db connection
  - use dependency injection
  - brief routing
  - support mysql driver, timeout auto reconnect
  - support redis driver, based on predis

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

  require_once __DIR__ . '/../routes/newroute.php';

```

#### how to dependency injection ?
example:
  make a model app/Models/Test.php
```php
<?php

namespace App\Models;

use App\Models\Model;

class Test extends Model
{
    public function getData()
    {
        return '<h1>Hello, welcome to WorkerA</h1>';
    }
}

```
  in your controller app/Controller/TestController.php
```php
<?php

namespace App\Controller;
use App\Controller\Controller;
use WorkerF\Http\Requests;
use App\Models\Test;

class TestController extends Controller
{
    // IOC Container will search dependen automatically, and inject
    public function test(Test $test, Requests $request)
    {
        $rst = $test->getData();

        return $rst;
    }
}

```
it works !

#### database query

config file : config/database.php

1 - use DB , just like laravel
```php
// Native pdo method, query\exec\prepare...
DB::connection('con1')->query('select * test_table limit 0, 30');

// query construct
$rst = DB::connection('con1')->table('test_table')
     ->where('id', '<', 10)
     ->get();
// join
$rst = DB::connection('con1')->table('test_table1')
     ->leftJoin('test_table2', 'test_table1.some_id', 'test_table2.some_id')
     ->select('test_table2.some_id')
     ->where('test_table2.some_id', '<', 10)
     ->get();

// Complex condition
$rst = DB::connection('con1')->table('test_table')
     ->where('id', '<', 10)
     ->orWhereBrackets(function($query) {
        $query->where('id', '1')
              ->orWhere('id', '3');
     })
     ->orderBy('id', 'DESC')
     ->get();

// sub query
$rst = DB::connection('con1')->table('test_table1')
     ->whereInSub('id', function($query) {
          $query->table('test_table2')
                ->select('id')->where('id', '<', '10');
     })
     ->orderBy('id', 'DESC')
     ->get();

// group by
$rst = DB::connection('con1')->table('test_table')
     ->groupBy('score')
     ->having('count(score)', '>', '60')
     ->get();

// sub query from table \ paginate
$rst = DB::connection('con1')->select('id','name','score')->fromSub(function($query) {
        $query->table('test_table')->where('id', '<', '100');
     })->where('id', '!=', 9)
     ->orderBy('id', 'ASC')
     ->paginate(10, 2);

......

```
more function look [ConnectorInterface](https://github.com/wazsmwazsm/WorkerF/blob/master/src/WorkerF/DB/Drivers/ConnectorInterface.php "ConnectorInterface")

2 - use Model , just like laravel

  make a model app/Models/Test.php
```php
<?php

namespace App\Models;

use App\Models\Model;

class Test extends Model
{   
    // set db connection (in config/database.php)
    protected $connection = 'con1';
    // set db table
    protected $table = 'test_table';
}

```  

   Model depend DB, so, the model method is the same as the DB method (except sub query from table) :

```php
  // callstatic
  $rst = Test::where(['id' => '2'])->get();
  // call instance, you can use DI instead of [new instance]
  $rst = (new Test)->where(['id' => '2'])->get();

  ......

```

more method look [ConnectorInterface](https://github.com/wazsmwazsm/WorkerF/blob/master/src/WorkerF/DB/Drivers/ConnectorInterface.php "ConnectorInterface")

#### use redis

  WorkerF\\DB\\Redis based on Predis extension, with laravel style. you can use Redis::method to call Predis method

1 - config config/database.php redis
```php    
'redis' => [
  'cluster' => FALSE,   // enable cluster?
  'options' => NULL,    // predis client options
  'rd_con' => [
      'default' => [
          'host'     => '127.0.0.1',
          'password' => NULL,
          'port'     => 6379,
          'database' => 0,
          // 'read_write_timeout' => 0,   // if use pub/sub function, uncomment this
      ],
  ]
]
```
2 - basic use
```php
<?php
namespace App\Controller;
use App\Controller\Controller;
use WorkerF\Http\Requests;
use App\Models\Test;
use Framework\DB\Redis;

class TestController extends Controller
{
    // IOC Container will search dependen automatically, and inject
    public function test(Test $test, Requests $request)
    {
        $value = Redis::get('rst');
        if( ! $value) {
             $rst = $test->getData();
             Redis::set('rst', json_encode($rst));
        } else {
             $rst = json_decode($value);
        }
        return $rst;
    }
}
```

3 - pipeline (predis native method)
```php
Redis::pipeline(function ($pipe) {
    for ($i = 0; $i < 1000; $i++) {
        $pipe->set("key:$i", $i);
    }
});
```

4 - publish / subscribe

tips: set config/database.php 'read_write_timeout' => 0 can solve predis 60s timeout issue
you can use it in onWorkerStart callback, subscribe will blocking the progress
```php
$http_worker->onWorkerStart = function($http_worker) {
    // subscribe
    Redis::subscribe('test-channel', function($msg) {
        echo $msg;
    });
};
```

more method predis [more method](https://github.com/nrk/predis "more method")

## Dependents
  [workerman](http://www.workerman.net/ "workerman")
  [predis](https://github.com/nrk/predis "predis")

## License

The WorkerA is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
