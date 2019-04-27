<?php
$config = [
    'id' => 'basic',
    'name' => 'AutoBy',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['app\config\settings'],
    'language' => 'ru',
    'sourceLanguage' => 'ru',
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Module',
        ],
        'gridview' =>  [
            'class' => '\kartik\grid\Module'
        ]
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'BpFsddFeU0Qaf9oYQ6Fv80iLa9ebcndv',
            'baseUrl' => ''
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'class' => 'app\components\User',
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['site/login']
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'transport' => [
                'plugins' => [
                    [
                        'class' => 'Swift_Plugins_ThrottlerPlugin',
                        'constructArgs' => [20]
                    ]     
                ]
            ]
        ],
        'db' => require(__DIR__ . '/db.php'),
        'msdb' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'sqlsrv:Server=178.172.173.223;Database=rosauto_autoby',
            'username' => 'rosauto_user',
            'password' => '1q2w3e4r',
            'charset' => 'utf8'
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'normalizer' => [
                'class' => 'yii\web\UrlNormalizer'
            ],
            'rules' => [
                'cars/<id:\d+>' => 'cars/view',
                'catalog/specifications/<brand>/<auto_model>/<generation>/<type>' => 'catalog/view',
                ['class' => 'app\components\CarsUrlRule'],
                
                '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
                '<action:\w+>/<id:\d+>' => 'site/<action>',
                'news' => 'news/index',
                'news/<slug>' => 'news/view',
                'catalog' => 'catalog/index',
                '<slug>' => 'site/page',
                '<action>' => 'site/<action>',
                '' => 'site/index'
            ]
        ],
        'formatter' => [
            'timeZone' => 'Europe/Minsk'
        ],
        'assetManager' => [
            'appendTimestamp' => true,
            'basePath' => '@webroot/assets',
            'baseUrl' => '@web/assets',
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => [
                        YII_DEBUG ? 'jquery.js' : 'jquery.min.js'
                    ]
                ],
                'yii\jui\JuiAsset' => [
                    'js' => [
                        YII_DEBUG ? 'jquery-ui.js' : 'jquery-ui.min.js'
                    ],
                    'css' => [
                        YII_DEBUG ? 'themes/smoothness/jquery-ui.css' : 'themes/smoothness/jquery-ui.min.css'
                    ]
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [
                        YII_DEBUG ? 'css/bootstrap.css' : 'css/bootstrap.min.css'
                    ]
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => [
                        YII_DEBUG ? 'js/bootstrap.js' : 'js/bootstrap.min.js'
                    ]
                ],
                'app\assets\AppAsset' => [
                    'css' => [
                        YII_DEBUG ? 'css/main.css' : 'css/main.min.css',
                        YII_DEBUG ? 'css/media.css' : 'css/media.min.css'
                    ],
                    'js' => [
                        YII_DEBUG ? 'js/main.js' : 'js/main.min.js'
                    ]
                ],
                'app\assets\AdminAsset' => [
                    'js' => [
                        YII_DEBUG ? 'js/admin.js' : 'js/admin.min.js'
                    ]
                ]
            ]
        ]
    ]
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module'
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
                'generators' => [
            'controller'   => [
                'class'     => 'yii\gii\generators\controller\Generator',
                'templates' => [
                    'actions' => '@app/components/gii/controller'
                ]
            ],
            'crud'   => [
                'class'     => 'yii\gii\generators\crud\Generator',
                'templates' => ['actions' => '@app/components/gii/crud']
            ]
        ]
    ];
}

return $config;