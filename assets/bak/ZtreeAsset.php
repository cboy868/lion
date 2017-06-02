<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author wansq <cboy868@163.com>
 * @since 2.0
 */
class ZtreeAsset extends AssetBundle
{
	public $sourcePath = '@bower/zTree';

    public $css = [
        'css/zTreeStyle/zTreeStyle.css'
    ];
    public $js = [
        'js/jquery.ztree.core.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
































