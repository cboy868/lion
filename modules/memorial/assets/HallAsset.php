<?php

namespace app\modules\memorial\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HallAsset extends AssetBundle
{
	public $sourcePath = '@app/modules/memorial/static/hall';

    public $css = [
    	'css/zx.css',
        'css/memorial.css',
        'css/merge.css',
        'memorial/ink/common.css',
        'css/import.css'
    ];
    public $js = [

    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset'
//        'app\modules\memorial\assets\BootstrapAsset'
    ];

}
