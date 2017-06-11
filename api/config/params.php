<?php

$setting = require(__DIR__ . '/../../config/setting.php');
$thumb = require(__DIR__ . '/../../config/thumb.php');
$web_params = require(__DIR__ . '/../../config/params.php');

$params = [
];


return \yii\helpers\ArrayHelper::merge($web_params, $setting,$thumb, $params);
