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
class ColorBoxAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'static/libs/colorbox/jquery.colorbox-min.js',
        'static/libs/colorbox/i18n/jquery.colorbox-zh-CN.js'
    ];
    public $css = [
        'static/libs/colorbox/colorbox.css'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'app\assets\JqueryuiAsset',
    ];

}
?>

<!-- \app\assets\ColorBoxAsset::register($this);
<a href="" class="artimg">
  <img class="back_img image" src="" alt="...">
</a> -->