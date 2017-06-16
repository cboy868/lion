<?php

namespace app\core\widgets\Ueditor;

use yii\web\AssetBundle;
use yii\web\View;
/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class UAsset extends AssetBundle
{

	public $js = [
        'ueditor.config.js',
        'ueditor.all.js',
    ];

    public $depends = [
        //'app\assets\AppAsset',
    ];
   
    public function init()
    {
        $this->sourcePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
    }
}


