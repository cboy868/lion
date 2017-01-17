<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\core\helpers;

/**
 * StringHelper
 *
 */
class StringHelper extends \yii\helpers\BaseStringHelper
{
	public function range($length){ 
		$str = '0123456789abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ';//62个字符 
		$strlen = 59; 
		while($length > $strlen){ 
			$str .= $str; 
			$strlen += 59; 
		} 
		$str = str_shuffle($str); 
		return substr($str,0,$length); 
	} 
}
