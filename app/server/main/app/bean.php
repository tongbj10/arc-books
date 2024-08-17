<?php declare(strict_types=1);

return [
    'config'   => [
        'path' => __DIR__ . '/../config',
        'env' => env('APP_ENV','dev')
    ],
    'noticeHandler'      => [
        'logFile' => '@runtime/logs/notice-%d{Y-m-d-H}.log',
        'levels'    => 'notice,info,debug,trace',
    ],
    'applicationHandler' => [
        'class' => \App\Common\Log\Handler\ReporterHandler::class,
        'logFile' => '@runtime/logs/error-%d{Y-m-d}.log',
        'levels'    => 'error,warning,critical,alert,emergency',
    ],
    'logger'             => [
        'flushRequest' => false,
        'enable'       => true,
        'json'         => true,
        'handlers'     => [
            'application' => \bean('applicationHandler'),
            'notice'      => \bean('noticeHandler')
        ],
    ],
	'db' => [
		'class'  => \Swoft\Db\Database::class,
		'charset'  => 'utf8mb4',
		'prefix'   => '',
        'dsn'      => 'mysql:dbname=tbj-test;host=172.100.29.112:3306',
        'username' => 'root',
        'password' => '123456',
		'config'   => [
			'collation' => 'utf8mb4_general_ci',
			'strict'    => false,
			'timezone'  => '+8:00',
			'modes'     => 'NO_ENGINE_SUBSTITUTION,STRICT_TRANS_TABLES',
			'fetchMode' => PDO::FETCH_ASSOC
		],
	],
    'db.pool' => [
        'class'       => \App\Common\Db\DbPool::class,
        'database'    => \bean('db'),
        'minActive'   => 1,
        'maxActive'   => 10,
        'maxWait'     => 0,
        'maxWaitTime' => 0,
        'maxIdleTime' => 60,
    ],
    'redis'      => [
        'class'         => \Swoft\Redis\RedisDb::class,
        'host'          => '172.100.29.113',
        'port'          => '6379',
        'database'      => 0,
        'retryInterval' => 10,
        'readTimeout'   => 0,
        'timeout'       => 3,
        'option'        => [
            'prefix'      => '',
            'serializer' => Redis::SERIALIZER_PHP
        ],
    ],
    'redis.pool'     => [
        'class'   => \Swoft\Redis\Pool::class,
        'redisDb' => \bean('redis'),
        'minActive'   => 1,
        'maxActive'   => 10,
        'maxWait'     => 0,
        'maxWaitTime' => 0,
        'maxIdleTime' => 60,
    ],
    'rpcServer'          => [
        'class' => \Swoft\Rpc\Server\ServiceServer::class,
        'port' => 18307,
        'on'       => [
            \Swoft\Server\SwooleEvent::TASK   => bean(\Swoft\Task\Swoole\TaskListener::class),
            \Swoft\Server\SwooleEvent::FINISH => bean(\Swoft\Task\Swoole\FinishListener::class)
        ],
        'process'  => [],
        /* @see \Swoft\Rpc\Server\ServiceServer::$setting */
        'setting'  => [
            'task_worker_num'       => 12,
            'task_enable_coroutine' => true,
            'worker_num'            => 4
        ]
    ],
    'consul' => [
        'host' => config('consul.host','127.0.0.1'),
        'port' => config('consul.port',8500)
    ],
];