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
        'css/slideshow.css',
        'css/main.css',
        'css/index.css',
        'css/index-respone.css',
        'css/LoginPanel.css',
        'css/zebra_dialog_flat.css',
        'css/login.css',
        'css/share_style0_24.css',
        'css/slide_share.css'
    ];
    public $js = [
        'js/hm.js',
        'js/zebra_dialog.js',
        'js/Command.js',
        'js/DataEx.js'
    ];

    public $depends = [
        'app\modules\memorial\assets\BootstrapAsset'
    ];

}
