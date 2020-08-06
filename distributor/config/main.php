<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-distributor',
    'name'=>'经销商后台',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'distributor\controllers',
    'defaultRoute' => 'main', // 默认控制器
    'bootstrap' => ['log'],
    'language'=>'zh-CN',
    'modules' => [
        
        'gii' => [
            'class' => 'yii\gii\Module',
            'allowedIPs' => ['127.0.0.1', '::1', '192.168.1.*'] // 按需调整这里
        ],
    ],
   
    'components' => [
        'request' => [
            'csrfParam' => '_csrf_distributor',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-distributor', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-distributor',
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
                    'categories' => ['test'],
                    'logFile' => '@app/runtime/logs/test.log',
                    'maxFileSize' => 1024 * 20,
                    'maxLogFiles' => 5
                ]


            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        
    ],
   
        
    'params' => $params,
];
