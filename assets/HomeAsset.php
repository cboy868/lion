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
class HomeAsset extends AssetBundle
{
    public $sourcePath = '@app/web/theme/site/static';

    public $js = [
        // 'js/bootstrap.min.js',
        'bootstrap/js/bootstrap.min.js',
        'js/jquery.ui.totop.min.js',
        'js/jquery.easing.1.3.js'
    ];

    public $css = [
    	'bootstrap/css/bootstrap.min.css',
    	'bootstrap/css/bootstrap-theme.min.css',
    	'css/styles.css',
    	'css/_custom_store1.css',
    	'css/n.css',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}
