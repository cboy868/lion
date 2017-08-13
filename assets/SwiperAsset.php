<?php
namespace app\assets;

use yii\web\AssetBundle;

class SwiperAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'static/libs/swiper-3.4.2/css/swiper.min.css',
    ];
    public $js = [
        'static/libs/swiper-3.4.2/js/swiper.min.js',
    ];
    public $depends = [
//        'yii\web\YiiAsset',
    ];
}
