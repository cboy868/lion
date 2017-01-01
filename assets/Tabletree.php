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
class Tabletree extends AssetBundle
{
	public $sourcePath = '@bower/jquery-treetable';
    public $css = [
        'css/jquery.treetable.css',
        'css/jquery.treetable.theme.default.css'
    ];
    public $js = [
        'jquery.treetable.js'
    ];

    public $depends = [
        'app\assets\AppAsset',
    ];
    
}
