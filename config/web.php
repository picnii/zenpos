<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'zenpos',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
     'modules' => [
        'api' => [
            'class' => 'app\modules\api\Api',
            // ... other configurations for the module ...
        ],
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'zxcxc',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'urlManager' => [
                'enablePrettyUrl' => true,
                
                'showScriptName' => false,
                'rules' => [
                    ['class' => 'yii\rest\UrlRule', 'controller' => 'api/branch', 
                        'extraPatterns' => [
                            'GET info' => 'info',
                            'GET logout' => 'logout',
                            'GET {id}/sale' => 'sale', // 'xxxxx' refers to 'actionXxxxx'
                            'POST {id}/sale/update' => 'updatesale', // 'xxxxx' refers to 'actionXxxxx'
                            'POST {id}/product/update' => 'updateproduct',
                        ],
                    ],
                ],
                // ...
        ],
        
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\Brand',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'db' => require(__DIR__ . '/db.php'),
        
    ],
    
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
