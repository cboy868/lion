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

    /**
     * 阿拉伯数字转中文数字
     */
    public static function num2rmb ($num)
    {
        //数字和单位预定义
        $num_cn_str = "零壹贰叁肆伍陆柒捌玖";
        $unit_str = "分角元拾佰仟万拾佰仟亿";
        $num_rmb = "";
        //四舍五入到小数点后两位并进行整数化
        $num = round($num, 2);
        $num = $num * 100;

        $i = 0;
        //进行转码
        while (1) {
            if ($i == 0) {
                $n = substr($num, strlen($num)-1, 1);
            } else {
                $n = $num % 10;
            }

            //utf-8编码
            $num_cn = substr($num_cn_str, 3 * $n, 3);
            $unit = substr($unit_str, 3 * $i, 3);

            if ($n != '0' || ($n == '0' && ($unit == '亿' || $unit == '万' || $unit == '元'))) {
                $num_rmb = $num_cn . $unit . $num_rmb;
            } else {
                $num_rmb = $num_cn . $num_rmb;
            }

            $i = $i + 1;
            $num = $num / 10;
            $num = (int)$num;
            if ($num == 0) {
                break;
            }
        }

        //加单位
        $j = 0;
        $slen = strlen($num_rmb);
        while ($j < $slen) {
            $m = substr($num_rmb, $j, 6);
            if ($m == '零元' || $m == '零万' || $m == '零亿' || $m == '零零') {
                $left = substr($num_rmb, 0, $j);
                $right = substr($num_rmb, $j + 3);
                $num_rmb = $left . $right;
                $j = $j-3;
                $slen = $slen-3;
            }
            $j = $j + 3;
        }

        //如果有一个“0”时,把它去了
        if (substr($num_rmb, strlen($num_rmb)-3, 3) == '零') {
            $num_rmb = substr($num_rmb, 0, strlen($num_rmb)-3);
        }
        return $num_rmb;
    }
}
