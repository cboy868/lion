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
class SelectizeAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css=[
    	'static/libs/selectize.js-master/dist/css/selectize.css'
    ];
    public $js = [
        'static/libs/selectize.js-master/dist/js/standalone/selectize.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'app\assets\JqueryuiAsset'
    ];

}
