<?php

namespace app\core\widgets\Webup;

use yii\web\AssetBundle;
use yii\web\View;
/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class NewsAsset extends AssetBundle
{
	public $css = [
		'webuploader.css',
		'news.css'
	];

	public $js = [
        'webuploader.nolog.min.js',
        'newsphoto.js'
    ];
   
    public function init()
    {
        $this->sourcePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
    }

    public $depends = [
        'yii\web\YiiAsset',
    ];
}


