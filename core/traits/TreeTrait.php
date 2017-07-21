<?php

namespace app\core\traits;

use app\core\helpers\ArrayHelper;
use Yii;
use yii\db\Query;
use app\core\models\Attachment;

trait TreeTrait {


    /**
     * @name 取所有父级
     */
    public function getParents()
    {
        if ($this->isRoot()) {
            return null;
        }

        $pids = explode('.', $this->code);
        
        return self::find()->where(['id'=>$pids])->asArray()->all();
    }

    /**
     * @name 取父级
     */
    public function getParent()
    {
        return self::findOne($this->pid);
    }

    /**
     * @name 取所有子节点
     */
    public function getDescendants($asArray = false)
    {
        if ($this->isLeaf()) {
            return [];
        }

        $query = self::find()//->where(['<>', 'id', $this->id])
                             ->andWhere(['like', 'code', $this->code . '%', false])
                             ->orderBy('code asc');

        if ($asArray) {
            $query->asArray();
        }

        return $query->all();
    }

    public function getDirectSon($asArray = false)
    {
        if ($this->isLeaf()) {
            return [];
        }

        $query = self::find()->where(['pid'=>$this->id])
                                ->orderBy('id asc');

        if ($asArray) {
            $query->asArray();
        }

        return $query->all();
    }

    /**
     * @name 取所有子叶子节点 
     */
    public function getSonLeafs($asArray = false)
    {
        if ($this->isLeaf()) {
            return [];
        }

        $query = self::find()->where(['is_leaf'=>1])
                             ->andWhere(['like', 'code', $this->code . '%', false])
                             ->orderBy('code asc');

        if ($asArray) {
            $query->asArray();
        }

        return $query->all();
    }

    /**
     * @name 取兄弟元素
     */
    public function getSibling($asArray=false)
    {
        $query = self::find()
            ->where(['pid' => $this->pid])
            ->andWhere(['<>', 'id', $this->id])
            ->orderBy(['sort' => SORT_ASC]);

        if ( $asArray == true ) {
            $query->asArray();
        } 

        return $query->all();
    }


    /**
     * @name 判断是否叶子节点
     */
    public function isLeaf()
    {
        return $this->is_leaf;
    }

    /**
     * @name 判断是否是根
     */
    public function isRoot()
    {
        return $this->pid == 0;
    }

    /**
     * @name 取层级
     */
    public function getLevel()
    {
        return $this->level;
    }


    /**
     * 获取自身数组形式的目录树
     */
    public function getTree()
    {
        $records = $this->getDescendants(true);

        return self::makeTree($records);
    }

    /**
     * $name 是否有有子元素
     */
    public function hasChild()
    {
        return (bool) self::find()->where(['pid' => $this->id])->one();
    }


    /**
     * @name 生成树
     */
    public static function genTree($id = 0)
    {
        return self::findOne($id)->getTree();
    }

    static public function selTree($condition=[], $id=0, $html='--')
    {
        if ($id) {
            $items = self::findOne($id)->getDescendants(true);
        } else {
            $items = static::find()->select(['id', 'pid', 'name', 'level', 'is_leaf'])
                          ->where($condition)
                          ->orderBy('code asc')
                          ->asArray()
                          ->all();
        }

        $arr = [];
        foreach ($items as &$item) {
            $arr[$item['id']] = str_repeat($html, $item['level']-1) . ' ' . $item['name'];
        }unset($item);


        return $arr;
    }


    static public function makeTree($records)
    {
        $tree = [];
        $records = ArrayHelper::index($records, 'id');

        foreach ($records as &$record) {
            if ( $record['pid'] != 0 && isset($records[$record['pid']])) {
                $records[$record['pid']]['children'][] = &$records[$record['id']];
            } else {
                $tree[] = &$records[$record['id']];
            }
        }unset($record);

        return $tree;
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if (!$this->pid) {
            $this->pid = 0;
            $this->level = 1;
        }

        return true;
    }


    public function afterSave($insert, $changedAttributes) 
    {
        $retval = parent::afterSave($insert, $changedAttributes);

        if ( $this->pid == 0) {
            $this->code = $this->id;
            $level = 1;
        } else {
            $parent = static::findOne($this->pid);
            $parent->is_leaf = 0;

            $this->code = $parent->code . '.' . $this->id;
            $this->level = $parent->level + 1;
            self::updateAll(['is_leaf'=>$parent->is_leaf], 'id=' . $this->pid);
        }

        self::updateAll(['code'=>$this->code, 'level'=>$this->level], 'id=' . $this->id);

        return $retval;
    }

    /**
     * @name 为树排序，前台表格树使用
     */
    public static function sortTree($condition=[], $order=null, $size='')
    {
        $sort = static::find()
                          ->filterWhere($condition)
                          ->orderBy('code asc' . ',' . $order)
                          ->asArray()
                          ->all();

        foreach ($sort as $k => &$v) {
            if (!isset($v['thumb']) && !is_null($v['thumb'])) break;
            if (!$v['thumb']) {
                $v['cover'] = '';
                continue;
            }
            $v['cover'] = Attachment::getById($v['thumb'], $size);
        }unset($v);

        return $sort;
    }

}