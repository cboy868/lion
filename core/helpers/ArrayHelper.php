<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\core\helpers;

/**
 * ArrayHelper provides additional array functionality that you can use in your
 * application.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ArrayHelper extends \yii\helpers\BaseArrayHelper
{

    public static function group($array, $field)
    {
        $result = [];

        foreach ($array as $k => $v) {
            $result[$v[$field]][] = $v;
        }

        return $result;
    }
    
	/**
     * @name 数组组合
     */
    public static function arrCombin($arr = [])
    {
        $re = array_shift($arr);
        if (!$re){
            return [];
        }
        if (!$arr) {
            $result = [];
            foreach ($re as $k => $v) {
                $result[][] = $v;
            }
            return $result;
        }
        $n = 0;
        foreach ($arr as $vals) {
            $result = [];
            foreach ($re as $k => $v) {
                foreach ($vals as $val) {
                    if ($n>0) {
                        $d = $v;
                        $d[] = $val;
                        $result[] = $d;
                    } else {
                        $result[] = [$v, $val];
                    }
                }
            }

            $re = $result;
            $n++;
        }

        return $result;
    }


    public static function recursion($arr, $pid=0, $type=1,$fid=0, $level=0) {
        switch($type) {
            case 1 : //组合多维数组
                $arr = \yii\helpers\ArrayHelper::index($arr, 'id');
                foreach ($arr as $item){
                    $arr[$item['pid']]['child'][$item['id']] = &$arr[$item['id']];
                }
                return isset($arr[0]['child']) ? $arr[0]['child'] : array();
            case 2 : //组合一维数组,菜单下拉选择形式
                static $array = array();
                static $i = -1;
                $i++;
                foreach ($arr as $v) {
                    if ($v['pid'] == $pid) {
                        $array[$i] = $v;
                        $array[$i]['lv'] = $level;
                        $array[$i]['html'] = str_repeat('--', $level);
                        static::recursion($arr, $v['id'], $type, $fid, $level + 1);
                    }
                }
                return $array;

            case 3 : //传递分类ID返回所有父级
                static $array = array();
                foreach ($arr as $v) {
                    if ($v['id'] == $fid) {
                        $array[$v['id']] = $v;
                        static::recursion($arr, $pid, $type, $v['pid']);
                    }
                }
                return array_reverse($array);
        }
    }
}
