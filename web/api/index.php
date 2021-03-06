<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');
ini_set('memory_limit','256M');

require(__DIR__ . '/../../config/functions.php');
require(__DIR__ . '/../../../framework/vendor/autoload.php');
require(__DIR__ . '/../../../framework/vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../../config/api/bootstrap.php');

$config = require(__DIR__ . '/../../config/api/main.php');

(new yii\web\Application($config))->run();

Yii::$classMap['Fpdf'] = '@app/core/libs/fpdf181/chinese.php';
