<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;
/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class SelectAsset extends AssetBundle
{


    public $sourcePath = '@bower/bootstrap-select/dist';

    public $css = [
        'css/bootstrap-select.min.css'
    ];
    public $js = [
        'js/bootstrap-select.min.js',
        'js/i18n/defaults-zh_CN.min.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];

}
