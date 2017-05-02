<?php

$setting = require(__DIR__ . '/../../config/setting.php');

$params = [
];


return \yii\helpers\ArrayHelper::merge($setting, $params);
