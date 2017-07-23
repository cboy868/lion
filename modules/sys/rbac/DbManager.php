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
use app\modules\sys\rbac\Item;

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
     * @return array
     * @name 取所有权限项
     */
    public function getPermissions()
    {
        $query = (new Query)
            ->from($this->itemTable)
            ->where(['type' => Item::TYPE_PERMISSION]);

        $items = [];
        foreach ($query->all($this->db) as $row) {
            $items[$row['name']] = $this->populateItem($row);
        }

        return $items;
    }

    protected function getItems($type)
    {
        $query = (new Query)
            ->from($this->itemTable)
            ->where(['type' => $type]);

        $items = [];
        foreach ($query->all($this->db) as $row) {
            $items[$row['name']] = $this->populateItem($row);
        }

        return $items;
    }

    public function checkAccess($userId, $permissionName, $params = [])
    {
        if ($userId == 1) {
            return true;
        }
        $assignments = $this->getAssignments($userId);

        if ($this->hasNoAssignments($assignments)) {
            return false;
        }

        $this->loadFromCache();
        if ($this->items !== null) {
            return $this->checkAccessFromCache($userId, $permissionName, $params, $assignments);
        } else {
            return $this->checkAccessRecursive($userId, $permissionName, $params, $assignments);
        }
    }

//    public function getPermissionsByUser($userId)
//    {
//
//        if ($userId == 1) {
//            $query = (new Query)->select('b.*')
//                    ->from(['a' => $this->assignmentTable, 'b' => $this->itemTable])
//                    ->where('{{a}}.[[item_name]]={{b}}.[[name]]')
//                    ->andWhere(['b.type' => Item::TYPE_PERMISSION]);
//
//            $permissions = [];
//            foreach ($query->all() as $row) {
//                $permissions[$row['name']] = $this->populateItem($row);
//            }
//
//            p($this->assignmentTable);die;
//
//            p($permissions);die;
//            return $permissions;
//        }
//        if (empty($userId)) {
//            return [];
//        }
//
//        $directPermission = $this->getDirectPermissionsByUser($userId);
//        $inheritedPermission = $this->getInheritedPermissionsByUser($userId);
//
//        return array_merge($directPermission, $inheritedPermission);
//    }

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
