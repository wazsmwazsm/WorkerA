# WorkerA

[中文文档](https://github.com/wazsmwazsm/WorkerA/README_CN.md  "中文文档")

## About

  a http framework for workerman

  - memory-resident
  - multiprocess, Highly concurrent
  - singleton db connection
  - use dependency injection
  - brief routing
  - support mysql driver, timeout auto reconnect

  Not allround but brief, Extensible, efficient

## How to use?

### install

  composer create-project wazsmwazsm/workera your-project-name --prefer-dist

### Requires

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

### use
  - config/ : configuration file
  - app/Controller/ : your controller file
  - app/Models/ : your model file
  - routes/ : your route file

#### run http mode
  sudo php WorkerStart.php start -d

#### run https mode
  modify HttpsStart.php, replace local_cert\local_pk to your own certificate
  sudo php HttpsStart.php start -d

## Dependents
  [workerman](http://www.workerman.net/ "workerman")

## License

The WorkerA is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
