<?php

namespace app\assets;

use yii\web\AssetBundle;

class MemberAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'static/ace/css/ace.css',
        'static/ace/css/ace-skins.min.css'
    ];
    public $js = [
        'static/ace/js/ace-extra.min.js',
        'static/ace/js/jquery-ui.custom.min.js',
        'static/ace/js/ace.min.js',
        'static/site/site.js',
    ];
    public $depends = [
        'app\assets\FontawesomeAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'app\assets\TodcAsset'
    ];
}
