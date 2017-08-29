<?php

namespace app\modules\memorial\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class SiteAsset extends AssetBundle
{
	public $sourcePath = '@app/modules/memorial/static';

    public $css = [
        'site/css/main.css',
        'site/css/index.css',
        'hall/memorial/ink/common.css',
    ];
    public $js = [
        'site/js/index.js',
    ];

    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
        'yii\web\YiiAsset'//这个只用到了他的post退出功能
    ];

}
