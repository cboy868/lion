<?php
namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;

class VueAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'static/libs/vue/vue.min.js',
        'static/libs/vue/vue-resource/vue-resource.min.js',
    ];
    public $css = [
    ];
    public $depends = [
    ];
}