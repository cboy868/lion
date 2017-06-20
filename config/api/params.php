<?php

$setting = require(__DIR__ . '/../setting.php');
$thumb = require(__DIR__ . '/../thumb.php');
$web_params = require(__DIR__ . '/../params.php');

$params = [
];


return \yii\helpers\ArrayHelper::merge($web_params, $setting,$thumb, $params);
