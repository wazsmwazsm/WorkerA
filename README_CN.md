# WorkerA

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

### 安装

  composer create-project wazsmwazsm/workera your-project-name --prefer-dist

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

### 使用
  - config/ : 存放配置文件
  - app/Controller/ : 存放控制器文件
  - app/Models/ : 存放模型文件
  - routes/ : 存放路由文件

#### http 模式启动
  sudo php WorkerStart.php start -d

#### https 模式启动
  修改 HttpsStart.php 文件, 替换 local_cert、local_pk 为你自己的证书
  sudo php HttpsStart.php start -d

## 依赖
  [workerman](http://www.workerman.net/ "workerman")

## License

The WorkerA is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
