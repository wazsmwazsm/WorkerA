# WorkerA

[框架核心部分](https://github.com/wazsmwazsm/WorkerF  "框架核心部分")

## 关于

  一个基于 workerman 的 http 小型框架

  - 常驻内存
  - 多进程, 高并发
  - 单例的数据库连接
  - 使用依赖注入
  - 简洁的路由
  - 提供 mysql 驱动, 支持断线自动重连

  WorkerA 不是一个全面的、多功能的框架, 它很小, 只有一些最基础的功能。
  但是它高效、简介。通过 PSR-4 自动加载机制和自动依赖注入, 你可以尽可能的对其进行扩展。

## 怎么用?

### 环境需求

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
<?php
  require_once __DIR__ . '/../routes/newroute.php';

```


## 依赖
  [workerman](http://www.workerman.net/ "workerman")

## License

The WorkerA is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
