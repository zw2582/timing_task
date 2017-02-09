<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests/codeception');

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'language'=>'zh-CN',
    'modules' => [ 
        'supplier_v1' => [
            'class' => 'app\modules\supplier_v1\ConsoleModule'
        ],
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' =>false,//这句一定有，false发送邮件，true只是生成邮件在runtime文件夹下，不发邮件
            'transport' => [  
               'class' => 'Swift_SmtpTransport',  
               'host' => 'smtp.integle.com',  //每种邮箱的host配置不一样
               'username' => 'wei.w.zhou@integle.com',  
               'password' => 'as31415926',  
               'port' => '465',  
               'encryption' => 'ssl',  
            ],   
            'messageConfig'=>[  
               'charset'=>'UTF-8',  
               'from'=>['wei.w.zhou@integle.com'=>'integle_admin']  
            ],  
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['trace'],
                    'logFile' => '@app/runtime/logs/trace.log',
                ],
                [
                    'class' => 'yii\log\EmailTarget',
                    'levels' => ['error', 'warning'],
                    'message' => [
                        'to' => ['xiangui.x.li@integle.com','chen.c.huang@integle.com','congying.c.li@integle.com','wei.w.zhou@integle.com'],//, 'chen.c.huang@integle.com','fei.f.wu@integle.com','wei.w.zhou@integle.com'
                        'subject' => 'New Error Target:online integle_task',
                    ]
                ],
            ],
        ],
        'db' => $db['integle_hui'],
        'pg_platform' => $db['pg_platform']
    ],
    'params' => $params,
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
];

return $config;
