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
class ContextMenuAsset extends AssetBundle
{
	public $sourcePath = '@bower/jQuery-contextMenu/dist';

    public $css = [
    	'jquery.contextMenu.min.css'
    ];
    public $js = [
    	'jquery.contextMenu.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];

}