<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-ordersearch',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'ordersearch\controllers',
	'language'=>'zh-CN',
	//'homeUrl' => '/',  
    'components' => [
    	
        'request' => [
            'csrfParam' => '_csrf-fronordersearcht',
        	//'baseUrl' => '',  
        ],
        'user' => [
            'identityClass' => 'ordersearch\models\AdminUser',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-ordersearch', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-front',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
       'urlManager' => [
    				'enablePrettyUrl' => true,
    				'showScriptName' => false,
    				'suffix'=>".html",
    				'rules' => [
    						'<controller:\w+>/<id:\d+>'=>'<controller>/detail',
    				],
    		],
    ],
    'params' => $params,
	'defaultRoute' => 'index/index'
];
