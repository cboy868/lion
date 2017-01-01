<?php

namespace app\core\widgets\Webup;

use yii\web\AssetBundle;
use yii\web\View;
/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class WAsset extends AssetBundle
{

	public $css = [
		'webuploader.css',
		'style.css'
	];

	public $js = [
        'webuploader.nolog.min.js',
        'upload.js',
    ];
   
    public function init()
    {
        $this->sourcePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
    }
}


