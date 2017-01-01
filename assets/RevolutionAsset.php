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
class RevolutionAsset extends AssetBundle
{
    public $sourcePath = '@app/web/static/libs/revolution';

    public $js = [
        'jquery.themepunch.plugins.min.js',
        'jquery.themepunch.revolution.min.js',
    ];

    public $css = [
    	'settings.css',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}
