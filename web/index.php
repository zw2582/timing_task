<?php
date_default_timezone_set('Asia/Shanghai');

if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') { // windows系统(开发用)
    defined('YII_DEBUG') or define('YII_DEBUG', true);
    defined('YII_ENV') or define('YII_ENV', 'dev');
} 

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/../config/web.php');

(new yii\web\Application($config))->run();
