<?php

namespace app\modules\memorial\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class SiteAsset extends AssetBundle
{
	public $sourcePath = '@app/modules/memorial/static/site';

    public $css = [
        'css/main.css',
        'css/index.css',
    ];
    public $js = [
        'js/index.js'
    ];

    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset'
    ];

}
