# WorkerA

[框架核心部分](https://github.com/wazsmwazsm/WorkerF  "框架核心部分")

## 关于

  一个基于 [workerman](http://www.workerman.net/ "workerman") 的 http 小型框架

  - 常驻内存
  - 多进程, 高并发
  - 单例的数据库连接
  - 使用依赖注入
  - 简洁的路由
  - 提供 mysql 驱动, 支持断线自动重连
  - 提供 redis 驱动, 基于 predis

  WorkerA 不是一个全面的、多功能的框架, 它很小, 只有一些最基础的功能。
  但是它高效、简介。通过 PSR-4 自动加载机制和自动依赖注入, 你可以尽可能的对其进行扩展。


## 环境需求

  PHP 5.4 或更高

  POSIX 兼容 (Linux, OSX, BSD)

  POSIX PHP 扩展

  PCNTL PHP 扩展

  PDO PHP 扩展

  PDO_MYSQL PHP 扩展

  更好的并发 :

      EVENT 或 LIBEVENT PHP 扩展

  使用 Https :

      OPENSSL PHP 扩展

## 怎么用?

### 安装

  composer create-project wazsmwazsm/workera your-project-name --prefer-dist

### 使用

#### 目录结构
  - config/ : 存放配置文件
  - app/Controller/ : 存放控制器文件
  - app/Models/ : 存放模型文件
  - routes/ : 存放路由文件
  - WorkerStart.php : 启动文件

#### http 模式启动
  sudo php WorkerStart.php start -d

#### https 模式启动
  修改 HttpsStart.php 文件, 替换 local_cert、local_pk 为你自己的证书
  sudo php HttpsStart.php start -d

#### 建立路由, 就像 laravel 一样
```php
<?php
// 必须
use Framework\Http\Route;

// 普通路由
Route::get('/a/b', function() {
    echo 'a';
});

Route::post('/a/b', function() {
    echo 'a';
});

......

// 控制器@方法
Route::get('/', "App\Controller\TestController@test");

// 路由分组，支持路径前缀和命名空间前缀
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

如何加载新建的路由文件 ?

打开 bootstrap/boot.php 文件, 添加  
```php

  require_once __DIR__ . '/../routes/newroute.php';

```

#### 如何依赖注入 ?
例子:
  建立一个模型 app/Models/Test.php
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
  在你的控制器 app/Controller/TestController.php
```php
<?php

namespace App\Controller;
use App\Controller\Controller;
use WorkerF\Http\Requests;
use App\Models\Test;

class TestController extends Controller
{
    // IOC 容器会自动查找需要的依赖、进行注入
    public function test(Test $test, Requests $request)
    {
        $rst = $test->getData();

        return $rst;
    }
}

```
执行成功 !

#### 数据库查询

配置文件 : config/database.php

1 - 使用 DB 构造器, 就像 laravel 一样l
```php
// 原生的 PDO 方法, query\exec\prepare...
DB::connection('con1')->query('select * test_table limit 0, 30');

// 构造查询
$rst = DB::connection('con1')->table('test_table')
     ->where('id', '<', 10)
     ->get();

// join 查询
$rst = DB::connection('con1')->table('test_table1')
     ->leftJoin('test_table2', 'test_table1.some_id', 'test_table2.some_id')
     ->select('test_table2.some_id')
     ->where('test_table2.some_id', '<', 10)
     ->get();

// 复杂条件查询
$rst = DB::connection('con1')->table('test_table')
     ->where('id', '<', 10)
     ->orWhereBrackets(function($query) {
        $query->where('id', '1')
              ->orWhere('id', '3');
     })
     ->orderBy('id', 'DESC')
     ->get();

// 子查询
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

// 表子查询 \ 分页
$rst = DB::connection('con1')->select('id','name','score')->fromSub(function($query) {
        $query->table('test_table')->where('id', '<', '100');
     })->where('id', '!=', 9)
     ->orderBy('id', 'ASC')
     ->paginate(10, 2);

......

```
更多方法请看 [ConnectorInterface](https://github.com/wazsmwazsm/WorkerF/blob/master/src/WorkerF/DB/Drivers/ConnectorInterface.php "ConnectorInterface")

2 - 使用模型 , 就像 laravel 一样

  make a model app/Models/Test.php
```php
<?php

namespace App\Models;

use App\Models\Model;

class Test extends Model
{   
    // 设置数据库连接 (config/database.php)
    protected $connection = 'con1';
    // 设置表
    protected $table = 'test_table';
}

```  

   模型是依赖 DB 构造器实现的, 所以模型可以使用 DB 的所有方法 (除了表子查询) :

```php
  // 静态调用
  $rst = Test::where(['id' => '2'])->get();
  // 实例调用, 你可以使用依赖注入代替直接 new 一个对象
  $rst = (new Test)->where(['id' => '2'])->get();

  ......

```

更多方法请看 [ConnectorInterface](https://github.com/wazsmwazsm/WorkerF/blob/master/src/WorkerF/DB/Drivers/ConnectorInterface.php "ConnectorInterface")

#### 使用 redis

  WorkerF\\DB\\Redis 基于 predis 扩展, 按照 laravel 的风格编写, 你可以适用 Redis::method 来调用 Predis 的原生方法

1 - 配置 config/database.php 的 redis 数组
```php    
'redis' => [
  'cluster' => FALSE,   // 开启 cluster?
  'options' => NULL,    // predis 客户端选项
  'rd_con' => [
      'default' => [
          'host'     => '127.0.0.1',
          'password' => NULL,
          'port'     => 6379,
          'database' => 0,
          // 'read_write_timeout' => 0,   // 如果使用 redis 的发布、订阅，取消这行注释
      ],
  ]
]
```
2 - 基本使用
```php
<?php
namespace App\Controller;
use App\Controller\Controller;
use WorkerF\Http\Requests;
use App\Models\Test;
use WorkerF\DB\Redis;

class TestController extends Controller
{
    public function test(Test $test, Requests $request)
    {
        // 从 redis 读取 key
        $value = Redis::get('rst');
        if( ! $value) {
             $rst = $test->getData();
             // 设置 key
             Redis::set('rst', json_encode($rst));
        } else {
             $rst = json_decode($value);
        }
        return $rst;
    }
}
```

3 - pipeline (predis 原生方法)
```php
Redis::pipeline(function ($pipe) {
    for ($i = 0; $i < 1000; $i++) {
        $pipe->set("key:$i", $i);
    }
});
```

4 - 发布 、订阅

提醒: 设置 config/database.php 'read_write_timeout' => 0 可以解决 predis 60s 超时的问题
你可以在 onWorkerStart 回掉函数中使用发布、订阅功能, subscribe 方法会阻塞当前进程
```php
$http_worker->onWorkerStart = function($http_worker) {
    // 订阅频道
    Redis::subscribe('test-channel', function($msg) {
        echo $msg;
    });
};
```

更多方法查看 predis [更多方法](https://github.com/nrk/predis "更多方法")

## 依赖
  [workerman](http://www.workerman.net/ "workerman")
  [predis](https://github.com/nrk/predis "predis")

## License

The WorkerA is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
