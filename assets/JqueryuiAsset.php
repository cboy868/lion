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
class JqueryuiAsset extends AssetBundle
{
    public $sourcePath = '@bower/jquery-ui';

    public $css = [
        'themes/base/jquery-ui.min.css'
    ];
    public $js = [
        'jquery-ui.min.js',
        'ui/i18n/datepicker-zh-CN.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];

    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD,//这里是为了把jqueryui 放在 bootstrap的前面  之后 有好方法再说
    ];

}
