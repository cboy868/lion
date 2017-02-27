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
class DateTimeAsset extends AssetBundle
{
	public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
		'static/libs/datetimepicker/build/jquery.datetimepicker.full.js'
	];
    public $css = [
    	'static/libs/datetimepicker/build/jquery.datetimepicker.min.css'
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];


}

// $.datetimepicker.setLocale('ch');
// $('#dt').datetimepicker({
//   timepicker:true, 
//   format:"Y-m-d H:i",
//   step:30,
//   weeks:true,
// })
// use app\assets\DateTimeAsset;

// DateTimeAsset::register($this);
