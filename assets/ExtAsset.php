<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;
/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ExtAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'static/site/ext.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'app\assets\JqueryuiAsset',
        'app\assets\SelectizeAsset'
    ];

}
