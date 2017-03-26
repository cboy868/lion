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
class AdminAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'static/site/site.css',
    ];
    public $js = [
        'static/site/site.js',
    ];
    public $depends = [
        'app\assets\FontawesomeAsset',
        'app\assets\AppAsset',
        'app\assets\TodcAsset',
        'app\assets\AceAsset',
    ];
}