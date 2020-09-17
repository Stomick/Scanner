<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/bootstrap.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'controllerMap' => [
        'images' => [
            'class' => 'phpnt\cropper\controllers\ImagesController',
        ],
    ],
    'components' => [

        'request' => [
            'csrfParam' => '_csrf',
        ],
        'mobileDetect' => [
            'class' => '\skeeks\yii2\mobiledetect\MobileDetect'
        ],
        'authClientCollection' => require (__DIR__ . '/autch.php'),

        'user' => [
            'identityClass' => 'models\MUser',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
            'suffix' => '.html',
            'rules' => [
                'debug' => '/debug',
                '/' => 'site/index',
                '<action:(login|captcha|registration|authregistr|authlogin|logout|test|reviews")>' => 'site/<action>',
             //   '<controller:\S+>/<action:\S+>' => '<controller><action>',
                '<controller:\S+>/<action:\S+>/<id:\S+>' => '<controller>/<action>',
            ],
        ],

    ],
    'params' => $params,
];
