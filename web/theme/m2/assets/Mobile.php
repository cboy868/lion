<?php

namespace app\web\theme\m2\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class Mobile extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
        '/theme/site/static/js/swiper.js',
        '//cdn.bootcss.com/jquery-weui/1.0.1/js/jquery-weui.min.js',
        '//cdn.bootcss.com/jquery-weui/1.0.1/js/city-picker.min.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
