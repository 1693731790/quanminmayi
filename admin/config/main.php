<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'admin',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'admin\controllers',
    'defaultRoute' => 'main', // 默认控制器
    'bootstrap' => ['log'],
    'modules' => [
       	 'rbac' => [
            'class' => 'mdm\admin\Module',
        ],
        'dc' => [
            'class' => 'admin\modules\dc\Module',
        ],
        'jdgoods' => [
            'class' => 'admin\modules\jdgoods\Module',
        ],
        'call' => [
            'class' => 'admin\modules\call\Module',
        ],
        'gii' => [
            'class' => 'yii\gii\Module',
            'allowedIPs' => ['127.0.0.1', '::1', '*.*.*.*'] // 按需调整这里
        ],
    ],
    'aliases' => [ 
        '@mdm/admin' => '@vendor/mdmsoft/yii2-admin',
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-admin',
        ],
        'user' => [
            'identityClass' => 'common\models\Admin',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-admin', 'httpOnly' => true],
        ],
        /*'user' => [
            'identityClass' => 'common\models\sys\Manager',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
            
        ],*/

        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-admin',
            'timeout' => 86400,
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
        'authManager' => [ 
            'class' => 'yii\rbac\DbManager', 
            'defaultRoles' => ['guest'], 
        ], 
    ],
  	 'as access' => [
            'class' => 'mdm\admin\components\AccessControl',
            'allowActions' => [
                'site/*',
                'gii/*',
                'app/order/contract',
            ]
        ],
   
    'params' => $params,
];
