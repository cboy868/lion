<?php
/**
 * @name 权限项
 * 继承自 框架
 */

namespace app\modules\sys\rbac;

use Yii;
use yii\db\Query;
use yii\base\NotSupportedException;
use yii\helpers\ArrayHelper;
/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Permission extends Item
{

	const LEVEL_MOD = 1; //level=1 为模块
    const LEVEL_CTRL = 2; //控制器
    const LEVEL_METHOD = 3; //方法

    public $type = self::TYPE_PERMISSION; //类型为权限项

    public static $itemTable = '{{%auth_item}}';

	/**
	 * @name 权限项初始化
	 * 所有权限项入库
	 */
	public static function sync()
	{
		$permissions = self::compareData();

		$connection = Yii::$app->db;
		$transaction = $connection->beginTransaction();

		try {
			foreach ($permissions as $k => $v) {
	            switch ($k) {
	                case 'del':
	                    $connection->createCommand()->delete(self::$itemTable, ['name'=>$v])->execute();
	                    break;

	                case 'update':
	                    foreach ($v as $val) {
	                        $connection->createCommand()->update(self::$itemTable, ['description' => $val['description']], ['name'=>$val['name']])->execute();
	                    }
	                    break;

	                case 'create':
	                	$data = [];
	                	foreach ($v as $k => $val) {
	                		$data[] = [$val['name'], $val['type'], $val['description'],$val['level'],$val['created_at'], $val['updated_at']];
	                	}

	                    $connection->createCommand()->batchInsert(
	                            self::$itemTable, 
	                            ['name',
	                            'type',
	                            'description',
	                            'level',
	                            'created_at',
	                            'updated_at'], 
	                            $data
	                        )->execute();
	                    break;
	                
	                default:
	                    break;
	            }
	        }
	        $transaction->commit();
		} catch (Exception $e) {
			$transaction->rollBack();

			return false;
		}

        return true;
	}


    /**
     * @name 组合入库数据
     */
    public static function combinPermissions()
    {
        $tmp = File::combinPermission();

        $permissions = [];

        $now = time();
        $data = [
            'type' => self::TYPE_PERMISSION,
            'created_at' => $now,
            'updated_at' => $now
        ];
        foreach ($tmp as $key => $value) {
            $permissions[] = $data + ['name' => $key, 'level' => 1, 'description'=>''];

            foreach ($value as $ke => $val) {
                $permissions[] = $data + ['name' => $key.'/'.$ke, 'level' => 2, 'description'=>''];

                foreach ($val as $k => $v) {
                    $permissions[] = $data + ['name' => $k, 'description' => $v['des'], 'level' => 3];
                }
            }
        }

        return $permissions;
    }

    /**
     * @name 对比数据
     */
    public static function compareData()
    {
        $fl_permissions = self::combinPermissions();
        $db_permissions  = self::findPermissions();

        $db_permissions_k = ArrayHelper::getColumn($db_permissions, 'name');
        $fl_permissions_k = ArrayHelper::getColumn($fl_permissions, 'name');
        //1.查找数据库中不存在的数据
        //2.查找文件中已被删除的数据
        //3.数据库和文件中都存在的数据
        $permissions = [];

        $permissions['del'] = array_diff($db_permissions_k, $fl_permissions_k);
        $create_k = array_diff($fl_permissions_k, $db_permissions_k);
        $update_k = array_intersect($db_permissions_k, $fl_permissions_k);

        foreach ($fl_permissions as $k => $v) {
            switch ($v) {
                case in_array($v['name'], $update_k):
                    $permissions['update'][] = $v;
                    break;
                case in_array($v['name'], $create_k);
                    $permissions['create'][] = $v;
                    break;
                default:
                    break;
            }

        }

        return $permissions;
    }

    public static function getShowFormat($role_name=null)
    {

    	$permissions = self::findPermissions(self::LEVEL_METHOD);

    	if (!empty($role_name)) {
    		$auth = Yii::$app->authManager;
	        $own = $auth->getPermissionsByRole($role_name);
	        $won_keys = array_keys($own);

	        foreach ($permissions as $k => &$v) {
	            $v['check'] = in_array($v['name'], $won_keys);
	        }unset($v);
    	}

        $result = [];
        foreach ($permissions as &$v) {
            $cparse = explode('/', $v['name']);
            $v['title'] = empty($v['real_title']) ? $v['description'] : $v['real_title'];

            $result[$cparse[0]][$cparse[1]][$cparse[2]] = $v;
        }unset($v);

        return $result;
    }


    public static function findPermissions($level = null)
    {
        $filter = ['type'=>self::TYPE_PERMISSION];
        if ($level) {
            $filter['level'] = $level;
        }

        return $query = (new Query)
	            ->from(self::$itemTable)
	            ->where($filter)
	            ->all();
    }
}

