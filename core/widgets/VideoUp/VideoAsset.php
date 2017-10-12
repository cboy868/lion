<?php

namespace app\core\widgets\Videoup;

use yii\web\AssetBundle;
use yii\web\View;
/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class VideoAsset extends AssetBundle
{

	public $css = [
		'webuploader.css',
		'style.css'
	];

	public $js = [
        'webuploader.nolog.min.js',
        'videoupload.js',
    ];
   
    public function init()
    {
        $this->sourcePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
        parent::init();
    }

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}


