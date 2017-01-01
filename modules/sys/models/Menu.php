<?php

namespace app\modules\sys\models;

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
class Menu extends ActiveRecord
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
    public static function getList()
    {

        $auth = Yii::$app->authManager;
        $items = $auth->getPermissionsByUser(Yii::$app->user->id);

        $menus = self::find()
                    ->where(['status' => self::STATUS_ACTIVE])
                    ->orderBy('sort desc')
                    ->asArray()
                    ->all();
        foreach ($menus as $k => &$v) {
            if (empty($v['auth_name'])) {
                continue;
            }
            $code = explode('/', $v['auth_name']);


            $v['url'] = Url::toRoute(['/admin/' . $v['auth_name']]);

            // p($code);die;
            // $v['url'] = Url::toRoute(['/'.$code[1].'/'.$code[2]]);
            // if (strpos($code[0], '@')) {
            //     $arr = explode('@', $code[0]);
            //     $code[0] = $arr[1];
            //     $v['url'] = Url::toRoute(['/'.$code[0].'/'.$code[1].'/'.$code[2]]);
            // }
            
        }unset($v);
        
        $menus = \yii\helpers\ArrayHelper::index($menus, 'id');
        $menus = \app\core\helpers\Tree::recursion($menus,0,1);
        // p($menus);
        return $menus;
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
            [['pid'], 'safe']
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
            // 'method' => '方法'
        ];
    }
}
