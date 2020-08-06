<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);
Yii::$classMap['Mpdf'] = __DIR__ . '/../../vendor/mpdf/mpdf.php';  
return [
    'id' => 'app-backend',
    'name'=>'总后台',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'language'=>'zh-CN',
    'modules' => [
        'rbac' => [
            'class' => 'mdm\admin\Module',
        ],
        'dc' => [
            'class' => 'backend\modules\dc\Module',
        ],
        'jdgoods' => [
            'class' => 'backend\modules\jdgoods\Module',
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
            'csrfParam' => '_csrf_backend',
        ],
        'user' => [
            'identityClass' => 'common\models\Admin',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
