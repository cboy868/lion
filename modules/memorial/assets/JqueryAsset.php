<?php

namespace app\modules\memorial\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class JqueryAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/memorial/static/libs/jquery-3.2.1';

    public $js = [
        'jquery-3.2.1.min.js'
    ];

}