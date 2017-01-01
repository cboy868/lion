<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;
/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class PluploaduiAssets extends AssetBundle
{
    public $sourcePath = '@bower/plupload';

    public $css = [
        'js/jquery.ui.plupload/css/jquery.ui.plupload.css'
    ];
    public $js = [
        'js/plupload.full.min.js',
        'js/i18n/zh_CN.js',
        'js/jquery.ui.plupload/jquery.ui.plupload.js',
    ];

    public $depends = [
        'app\assets\JqueryuiAsset',
    ];
}
