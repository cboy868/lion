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
class InsCanvasAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'https://cdnjs.cloudflare.com/ajax/libs/jcanvas/20.1.2/min/jcanvas.min.js',
        'static/libs/insCanvas/canvas.min.js'
    ];
    public $depends = [
        'app\assets\JqueryuiAsset',
    ];

}
