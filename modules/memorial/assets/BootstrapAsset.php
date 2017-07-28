<?php

namespace app\modules\memorial\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class BootstrapAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/memorial/static/libs/bootstrap-3.3.7-dist';

    public $css = [
        'css/bootstrap.min.css',
        'css/bootstrap-theme.min.css'
    ];
    public $js = [
        'js/bootstrap.min.js'
    ];
    public $depends = [
        'app\modules\memorial\assets\JqueryAsset'
    ];

}
