# arc-books

#### 简单介绍下目录结构 main
```
├── app/    ----- 应用代码目录
│   ├── Common/            ----- 一些具有独立功能的 class bean （DB、Log、Model等）
│   ├── Console/           ----- 命令行代码目录 （脚本目录）
│   ├── Exception/         ----- 定义异常类目录
│   │   └── Handler/           ----- 定义异常处理类目录
│   ├── Http/              ----- HTTP 服务代码目录
│   │   ├── Controller/
│   │   └── Middleware/
│   ├── Helper/            ----- 助手函数
│   ├── Listener/          ----- 事件监听器目录
│   ├── Model/             ----- 模型、逻辑等代码目录
│   │   ├── Dao/
│   │   ├── Logic/
│   │   └── Entity/
│   ├── Rpc/               ----- RPC 服务代码目录
│   │   └── Service/
│   │   └── Middleware/
│   ├── Validator/         ----- 逻辑验证器
│   ├── Application.php    ----- 应用类文件继承自swoft核心
│   ├── AutoLoader.php     ----- 项目扫描等信息(应用本身也算是一个组件)
│   └── bean.php
├── bin/
│   ├── bootstrap.php
│   └── swoft              ----- Swoft 入口文件
├── config/                ----- 应用配置目录
│   ├── base.php               ----- 基础配置
│   └── db.php                 ----- 数据库配置
├── runtime/               ----- 临时文件目录（日志、上传文件、文件缓存等）
└── composer.json
```

#### 项目如何启动，代码测试调试
服务启动 docker-compose up
main/app/console/Command/TestCommand.php 中简单例如了方法的mock调用;
docker exec -it books php bin/swoft test:test
rpc服务模式，通信需接口调用，服务实现示例；可使用以上方式调试验证已有方法；

#### 本次设计选择MySQL作为数据库服务器；
PHP开发选择MySQL数据库是因为MySQL在易用性、性能、成本、安全性和可扩展性等方面具有显著优势。
安装配置简单、有丰富的文档和社群支持，多种存储引擎、查询速度快、并发处理能力；

#### 项目实现思路以及使用到的技术
高并发考虑如下：
1.限制访问次数， 比如五秒内之允许访问一次，
2.使用redis缓存。保证redis高可用，避免雪崩、穿透等。例如对于本次销量的统计，暂考虑一个月的过期时间，统计月内的销量；
高负载方面做了如下设计： 
1.使用Redis进行缓存，缓存计算排行榜数据, 巧妙利用有序集合的排序理念。 
2.预计算：在图书销售后，及时更新销售排行榜，而不是实时计算。
3.异步处理：在保证销售信息一致性和持久性后，后续或可使用消息队列或异步任务来处理排行榜更新，避免阻塞HTTP请求
4.docker的使用对于高并发下有着更为快速的复刻便利，分布式部署下，通过服务的扩展来实现高可用的负载均衡
5.优化查询：高并发下对数据库查询进行优化，使用索引等
