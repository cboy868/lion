<?php

namespace app\core\widgets\Webup;

use yii\web\AssetBundle;
use yii\web\View;
/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AreaAsset extends AssetBundle
{

	public $css = [
		'webuploader.css',
		'area.css'
	];

	public $js = [
        'webuploader.nolog.min.js',
        'albumupload.js'
    ];
   
    public function init()
    {
        $this->sourcePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
    }

    public $depends = [
        'yii\web\YiiAsset',
    ];
}


