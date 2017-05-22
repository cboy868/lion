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
	public static function range($length){ 
		$str = '0123456789abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ';//62个字符 
		$strlen = strlen($str);
		while($length > $strlen){ 
			$str .= $str; 
			$strlen += $strlen;
		} 
		$str = str_shuffle($str); 
		return substr($str,0,$length); 
	} 


	/**
	 * @name 字符串按长度分隔为数组 支持中文 
	 */
	public static function mbStrSplit($string, $len = 2, $indent=2)
	{

		$string = str_replace(PHP_EOL, '', $string);


		if ($indent) {
			$string = str_repeat(' ', $indent) . $string;
		}

	    $strlen = mb_strlen($string, 'utf8');

	    for ($i=0; $i < $strlen; $i=$i+$len) { 
	        $arr[] = mb_substr($string, $i, $len, 'utf8');
	    }

	    return $arr;
	}
}
