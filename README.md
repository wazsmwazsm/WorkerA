# WorkerA

安装、使用请查看 [文档]([Document](https://www.kancloud.cn/wazsmwazsm/workera/691859)
  "文档")。

## 是什么

WorkerA 是一个基于 [workerman](https://www.workerman.net/) 的小型 WebAPI 框架。

框架分 A (Application) 和 F (Framework) 两个项目进行单独管理。

框架源码地址：[WorkerA](https://github.com/wazsmwazsm/WorkerA)
框架核心源码地址：[WorkerF](https://github.com/wazsmwazsm/WorkerF)

## 能做什么

WorkerA 不是一个全面的、多功能的框架, 它很小, 只有一些最基础的功能。不像传统 MVC 框架那样支持模板解析、视图渲染，它只实现了 M 和 C，但是它高效、简洁。

### 高性能

基于 workerman 常驻内存的多进程模型，比传统的基于 LNMP、LAMP 模型的框架快几十倍以上。

### 可扩展

WorkerA 遵循  PSR-4 自动加载规范。

WorkerA 实现了一个基础的 IOC 容器，支持控制器的自动依赖注入，支持单例模式。

### 路由、中间件
WorkerA 提供了简单的路由，支持动态路由和路由缓存，你可以使用动态路由构建 RESTFul API，轻松实现一个 WebAPI 项目。

同时 WorkerA 也提供了一个好用的中间件，支持全局模式和路由模式，方便对数据过滤、验证。

### 数据操作
WorkerA 提供了一个实用的查询构造器，支持 mysql、postgresql、sqlite，简化对数据的操作。

## 特性

- 常驻内存
- 多进程, 高并发
- 使用依赖注入
- 简洁的中间件
- 简洁的路由
- 好用的查询构造器
- 提供 mysql postgresql sqlite 驱动, 支持断线自动重连
- 提供 redis 驱动, 基于 predis

## 项目依赖

[workerman](http://www.workerman.net/ "workerman")

[predis](https://github.com/nrk/predis "predis")

## License

The WorkerA is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
