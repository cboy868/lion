<?php

namespace app\modules\memorial\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HallAsset extends AssetBundle
{
	public $sourcePath = '@app/modules/memorial/static';

    public $css = [
    	'hall/css/zx.css',
        'hall/css/memorial.css',
        'hall/css/merge.css',
        'hall/memorial/ink/common.css',
        'hall/css/import.css'
    ];
    public $js = [
        'hall/js/index.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset'
//        'app\modules\memorial\assets\BootstrapAsset'
    ];

}
