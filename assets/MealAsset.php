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
class MealAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        // '/static/libs/meal/css/jquery.mmenu.all.css',
        // '/static/libs/meal/css/demo.css',
        // '/static/libs/meal/css/component.css',
        // '/static/libs/meal/css/leftdaohang.css',
        // '/static/libs/meal/css/demo.css',
    ];
    public $js = [
        // '/static/libs/meal/js/jquery.js',
        // '/static/libs/meal/js/jquery.mmenu.js',
        // '/static/libs/meal/js/jquery.mmenu.searchfield.js',
        // '/static/libs/meal/js/jquery.mmenu.header.js',
        // '/static/libs/meal/js/jquery.mmenu.labels.js',
        // '/static/libs/meal/js/jquery.mmenu.counters.js',
        // '/static/libs/meal/js/modernizr.custom.js',
        // '/static/libs/meal/js/jquery.nav.js',
        // '/static/libs/meal/js/easy.js',

    ];
    public $depends = [
        // 'yii\web\YiiAsset',
    ];

}
