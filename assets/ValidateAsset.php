<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;
/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ValidateAsset extends AssetBundle
{
    public $sourcePath = '@bower/validate';

    public $js = [
        'jquery-validate.min.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}
