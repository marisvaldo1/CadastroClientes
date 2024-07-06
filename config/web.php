<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'pt-BR', // Define o idioma padrão como português
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'betYNIFcgL41zBXsNXmm4g6H-zpqpw2q',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\Usuario',
            'enableAutoLogin' => true,
            'enableSession' => false,
            'loginUrl' => null,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
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
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'rules' => [
                '' => 'site/index',
                'login' => 'site/login',
                'logout' => 'site/logout',
                'contact' => 'site/contact',
                'about' => 'site/about',
                // APIs
                'POST v1/login' => 'auth/login',
                'POST v1/register' => 'auth/register',
                'GET v1/clientes' => 'cliente/index',
                'POST v1/clientes' => 'cliente/create',
                'GET v1/clientes/<id:\d+>' => 'cliente/view',
                'PUT v1/clientes/<id:\d+>' => 'cliente/update',
                'DELETE v1/clientes/<id:\d+>' => 'cliente/delete',
                'GET v1/produtos' => 'produto/index',
                'POST v1/produtos' => 'produto/create',
                'GET v1/produtos/<id:\d+>' => 'produto/view',
                'PUT v1/produtos/<id:\d+>' => 'produto/update',
                'DELETE v1/produtos/<id:\d+>' => 'produto/delete',
                'GET v1/produtos/cliente/<cliente_id:\d+>' => 'produto/list-by-cliente',
                'POST v1/test' => 'auth/test',
            ],
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'yii' => 'yii.php',
                    ],
                ],
            ],
        ],
    ],
    'modules' => [
        'v1' => [
            'class' => 'yii\base\Module',
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
