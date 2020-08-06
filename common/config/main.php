<?php
return [
    'bootstrap' => [
        // 'queue', // 把这个组件注册到控制台
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        // 'redis' => [
        //     'class' => \yii\redis\Connection::class,
        // ],
        // 'queue' => [
        //     'class' => \yii\queue\redis\Queue::class,
        //     'redis' => 'redis', // 连接组件或它的配置
        //     'channel' => 'queue', // Queue channel key
        //     'ttr' => 5 * 60, // Max time for anything job handling 
        //     'attempts' => 3, // Max number of attempts
        // ],

        // 后台可将此缓存清除
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@runtime/cache', 
        ],
      
        //不允许后台清除缓存
        'corecache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@runtime/corecache',
        ],
        
        'frontcache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info'],
                    'categories' => ['pay'],
                    'logFile' => '@app/runtime/Mylog/pay.log',
                    'maxFileSize' => 1024 * 2,
                    'maxLogFiles' => 20,
                ],
            ],
        ],
        'formatter' => [
            'timeZone'=>'Asia/Shanghai',
            'dateFormat' => 'php:Y-m-d',
            'timeFormat' => 'php:H:i:s',
            'datetimeFormat' => 'php:Y-m-d H:i:s',
            'currencyCode' => 'CNY',
        ],
    
        // 'elasticsearch' => [
        //     'class' => 'yii\elasticsearch\Connection',
        //     'nodes' => [
        //         ['http_address' => '127.0.0.1:9200'],
        //         // configure more hosts if you have a cluster
        //     ],
        // ],
        'wechat' => [
            'class' => 'maxwen\easywechat\Wechat',
            // 'userOptions' => []  # user identity class params
            // 'sessionParam' => '' # wechat user info will be stored in session under this key
            // 'returnUrlParam' => '' # returnUrl param stored in session
        ],
    ],


];
