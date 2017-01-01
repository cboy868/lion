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
class AceAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'static/ace/css/ace.css',
    ];
    public $js = [
        'static/ace/js/ace-extra.min.js',
        'static/ace/js/jquery-ui.custom.min.js',
        'static/ace/js/ace.min.js'
    ];
}