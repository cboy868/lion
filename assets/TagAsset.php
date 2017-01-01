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
class TagAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '/static/libs/tag_js/fm.tagator.jquery.css',
    ];
    public $js = [
        '/static/libs/tag_js/fm.tagator.jquery.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];

}
