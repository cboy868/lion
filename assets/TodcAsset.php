<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author wansq <cboy868@163.com>
 * @since 2.0
 */
class TodcAsset extends AssetBundle
{
	public $sourcePath = '@bower/todc-bootstrap';

    public $css = [
        'dist/css/todc-bootstrap.min.css'
    ];
    public $js = [
        'dist/js/bootstrap.min.js'
    ];
}
































