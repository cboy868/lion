<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\modules\sys\rbac;

use Yii;
use yii\db\Expression;
use yii\db\Query;
use app\core\helpers\ArrayHelper;

/**
 * @name rbac主类
 * @author wsq 
 */
class DbManager extends \yii\rbac\DbManager
{
   public function createRole($name)
    {
        $role = new Role;
        $role->name = $name;
        return $role;
    }
   

    protected function populateItem($row)
    {
        $class = $row['type'] == Item::TYPE_PERMISSION ? Permission::className() : Role::className();

        if (!isset($row['data']) || ($data = @unserialize($row['data'])) === false) {
            $data = null;
        }

        return new $class([
            'name' => $row['name'],
            'type' => $row['type'],
            'description' => $row['description'],
            'real_title' => $row['real_title'],
            'ruleName' => $row['rule_name'],
            'data' => $data,
            'createdAt' => $row['created_at'],
            'updatedAt' => $row['updated_at'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getChildren($name, $type=null, $level=null)
    {

        $filter = ['parent' => $name, 'name' => new Expression('[[child]]')];
        if ($type) {
            $filter['type'] = $type;
        }
        if ($level) {
            $filter['level'] = $level;
        }
        $query = (new Query)
            ->select(['name', 'type', 'description', 'rule_name', 'real_title', 'data', 'created_at', 'updated_at'])
            ->from([$this->itemTable, $this->itemChildTable])
            ->where($filter);

        $children = [];
        foreach ($query->all($this->db) as $row) {
            $children[$row['name']] = $this->populateItem($row);
        }

        return $children;
    }

    public function getUserIdsByRole($role_name, $type=null, $m=true)
    {


        if (empty($role_name)) {
            return [];
        }

        $childs = $this->getChildren($role_name, $type);

        $result = [];
        if ($childs) {
            foreach ($childs as $k => $v) {
                $tmp = (new Query)
                    ->from($this->assignmentTable)
                    ->where(['item_name' => (string) $v->name])
                    ->select('user_id')
                    ->all();
                $result = array_merge($result, $tmp);
            }
        }

        $tmp = (new Query)
            ->from($this->assignmentTable)
            ->where(['item_name' => (string) $role_name])
            ->select('user_id')
            ->all();

        $result = array_merge($result, $tmp);
        $result = ArrayHelper::getColumn($result, 'user_id');
        return $result;
    }



}
