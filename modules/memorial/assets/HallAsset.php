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
    	'css/zebra_dialog_flat.css',
        'css/main.css',
        'css/index.css',
        'css/share_style0_24.css',
        'css/slide_share.css',
        'css/owl.carousel.css',
        'css/owl.theme.css',
        'css/owl.transitions.css',

        'css/photo.css',
        'css/relist.css',
        'css/SacrificeLogList.css'

    ];
    public $js = [
//    	'js/hm.js',
//        'js/jquery-1.11.3.min.js',
//        'js/jquery.unobtrusive-ajax.js',
//        'js/DataEx.js',
//        'js/bootstrap.min.js',
//        'js/zebra_dialog.js',
//        'js/Command.js',
//        'js/init.js',
//        'js/imagesloaded.pkgd.min.js'
    ];

    public $depends = [
        'app\modules\memorial\assets\BootstrapAsset'
    ];

}
