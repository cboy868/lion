<?php

namespace app\core\helpers;

/**
* 
*/
class Tree
{
    
    public static function group($array, $field)
    {
        $result = [];
        foreach ($array as $k => $v) {
            $result[$v[$field]][] = $v;
        }

        return $result;
    }

    static public function makeTree($records)
    {
        $tree = [];
        $records = \yii\helpers\ArrayHelper::index($records, 'id');

        foreach ($records as $record) {
            if ( $record['pid'] != 0 && isset($records[$record['pid']])) {
                $records[$record['pid']]['children'][] = &$records[$record['id']];
            } else {
                $tree[] = &$records[$record['id']];
            }
        }
        return $tree;
    
    }

    static public function makeSel($records)
    {
        $sel=[];
        foreach ($records as $v) {
                $sel[$v['id']] = $v;
                $sel[$v['id']]['html'] = str_repeat('--', $v['level']-1);
        }
        return $sel;
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

    /**
     * @name 绝对的分组，只有一组也要分
     */
    public static function indexAbs($arr, $id, $group)
    {
        $result = [];

        foreach ($arr as $k => $v) {
            $result[$v[$group]][$v[$id]] = $v;
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


    public static function treeShow($categories, $userFunc)
    {
        $treeMenu   = array();
//        $userFunc = ['\app\core\helpers\Tree', 'createMenuLink']

        foreach($categories as $category)
        {
            $linkHtml = call_user_func($userFunc, $category);

            if(isset($treeMenu[$category->id]) and !empty($treeMenu[$category->id]))
            {
                if(!isset($treeMenu[$category->pid])) $treeMenu[$category->pid] = '';
                $treeMenu[$category->pid] .= "<li>$linkHtml";
                $treeMenu[$category->pid] .= "<ul>".$treeMenu[$category->id]."</ul>\n";

            }
            else
            {
                if(isset($treeMenu[$category->pid]) and !empty($treeMenu[$category->pid]))
                {
                    $treeMenu[$category->pid] .= "<li>$linkHtml\n";
                }
                else
                {
                    $treeMenu[$category->pid] = "<li>$linkHtml\n";
                }
            }
            $treeMenu[$category->pid] .= "</li>\n";


        }


        $lastMenu = "<ul class='tree'>" . @array_pop($treeMenu) . "</ul>\n";
        return $lastMenu;
    }

    public static function createMenuLink($category)
    {
        return Html::a($category->name,['#'] );
    }
}

