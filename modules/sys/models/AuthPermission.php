<?php
namespace app\modules\sys\models;

use Yii;
use yii\base\NotSupportedException;
use app\core\helpers\Files;
use yii\helpers\ArrayHelper;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class AuthPermission extends AuthItem
{

    protected $type = self::TYPE_PERMISSION;

    // public function rules()
    // {
    //     return [
    //     	[['name'], 'required'],
    //         [['type', 'level',  'created_at', 'updated_at'], 'integer'],
    //         [['name', 'real_title'], 'string', 'max' => 255],
    //     ];
    // }

    public function attributeLabels()
    {
        return [
            'name' => 'codename',
            'rule_name' => '规则名',
            'real_title' => '角色名',
            'description' => '注释',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * @name 取模块
     */
    public static function getMods()
    {
        $all = self::find()->where(['type'=>self::TYPE_PERMISSION, 'level'=>self::LEVEL_MOD])
                            ->select(['name', 'description', 'real_title'])
                            ->asArray()
                            ->all();

        $mu = [];
        foreach ($all as $k => $v) {
            $mu[$v['name']] = $v['name'];
        }

        return $mu;
    }

    /**
     * @name 取控制器
     */
    public static function getCtrls($mod='')
    {
        if (empty($mod)) {
            return [];
        }
        
        $filter = ['like', 'name', $mod . '/'];
        $all = self::find()->where(['type'=>self::TYPE_PERMISSION, 'level'=>self::LEVEL_CTRL])
                            ->andWhere($filter)
                            ->select(['name', 'description', 'real_title'])
                            ->asArray()
                            ->all();

        $mu = [];
        foreach ($all as $k => $v) {
            $mu[$v['name']] = $v['name'];
        }
        return $mu;
    }

    /**
     * @name 取方法
     */
    public static function getMethods($ctrl='')
    {

        if (empty($ctrl)) {
            return [];
        }
        $filter = ['like', 'name', $ctrl . '/'];
        $all = self::find()->where(['type'=>self::TYPE_PERMISSION, 'level'=>self::LEVEL_METHOD])
                            ->andWhere($filter)
                            ->select(['name', 'description', 'real_title'])
                            ->asArray()
                            ->all();

        $mu = [];
        foreach ($all as $k => $v) {
            $val = empty($v['real_title']) ? $v['name'] . ' ' . $v['description'] : $v['name'] . ' ' . $v['real_title'];
            $mu[$v['name']] = $val;
        }

        return $mu;
    }


}
