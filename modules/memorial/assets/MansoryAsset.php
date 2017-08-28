<?php

namespace app\modules\memorial\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class MansoryAsset extends AssetBundle
{
	public $sourcePath = '@app/modules/memorial/static/libs/mp-mansory';

    public $css = [
//        'css/index.css',
    ];
    public $js = [
        'mp.mansory.min.js',
    ];

    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
    ];

}
