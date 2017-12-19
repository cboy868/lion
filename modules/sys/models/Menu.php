<?php

namespace app\modules\sys\models;

use app\modules\sys\rbac\Item;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Url;
/**
 * This is the model class for table "{{%sys_menu}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $auth_name
 * @property integer $pid
 * @property string $icon
 * @property integer $sort
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Menu extends \app\core\models\Category
{

    const STATUS_ACTIVE = 1;
    const STATUS_DELETE = -1;

    public $mod;
    public $ctrl;
    // public $method;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sys_menu}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }

    /**
     * @title 取出所有菜单列表
     */
    public static function getList($condition=[])
    {
        $catch = Yii::$app->cache;
//        $catch->delete('admin_menu');
        $uid = Yii::$app->user->id;
//        if ($catch->get('admin_menu_' . $uid) !== false) {
//            return $catch->get('admin_menu' . $uid);
//        } else {
            $menus = self::authMenu($condition);
            foreach ($menus as $k => &$v) {
                if (empty($v['auth_name'])) {
                    continue;
                }
                $auth_name = substr_replace($v['auth_name'], '/admin', strpos($v['auth_name'], '/'), 0);
                $v['url'] = Url::toRoute(['/'.$auth_name]);
            }unset($v);

            $menus = \app\core\helpers\Tree::recursion($menus,0,1);
            $catch->set('admin_menu' . $uid, $menus, 3600);
//        }
        return $menus;
    }

    public static function authMenu($condition=null)
    {
        $query = self::find()->where(['status'=>self::STATUS_ACTIVE]);

        if ($condition != null) {
            $query->andWhere($condition);
        }

        $menus = $query->orderBy('sort desc')->asArray()->all();

        if (Yii::$app->user->id != 1) {
            $permissions = Yii::$app->authManager->getPermissionsByUser(Yii::$app->user->id);

            $result_menu = [];
            $pids = [];
            foreach ($menus as $v) {
                if (isset($permissions[$v['auth_name']])) {
                    $result_menu[] = $v;
                    $pids[] = $v['pid'];
                }
            }

            $menus = [];
            if (count($pids) > 0) {
                $parents = Menu::find()->where(['id'=>$pids])->orderBy('sort desc')->asArray()->all();
                $menus = array_merge($result_menu, $parents);
            }
        }
        return $menus;
    }

    public static function panels()
    {
        return Yii::$app->getModule('sys')->params['panels'];
    }

    public function getMenus($type = 1)
    {
        $menus = self::find()
                    ->where(['status' => self::STATUS_ACTIVE])
                    ->orderBy('sort desc')
                    ->asArray()
                    ->all();

        $menus = \app\core\helpers\Tree::recursion($menus,0,2);

        if ($type == 2) {
            return $menus;
        }

        $result = [];
        $result['0'] = '顶级';

        foreach ($menus as $v) {
            $result[$v['id']] = $v['html'] . $v['name'];
        }
        return $result;
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sort', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'required'],
            [['name', 'auth_name'], 'string', 'max' => 128],
            [['icon'], 'string', 'max' => 32],
            [['pid', 'ico'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '菜单名',
            'auth_name' => '权限项',
            'pid' => '父级菜单',
            'icon' => '图标',
            'sort' => '排序',
            'status' => '状态',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'mod'=>'模块',
            'ctrl' => '控制器',
            'ico' => '大图标'
            // 'method' => '方法'
        ];
    }

    public static function getSiblingsMenus($auth)
    {
        $model = self::find()->where(['auth_name'=>$auth])->one();

        if (!$model) {
            return [];
        }

        if ($model->pid == 0) {
            return [];
        }

        $menus = self::authMenu(['pid'=>$model->pid]);


        foreach ($menus as $k => &$v) {
            if (empty($v['auth_name'])) {
                unset($menus[$k]);
                continue;
            }
            $auth_name = substr_replace($v['auth_name'], '/admin', strpos($v['auth_name'], '/'), 0);
            $v['url'] = Url::toRoute(['/'.$auth_name]);
        }unset($v);


        return $menus;
    }
}
