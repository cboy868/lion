<?php

namespace app\modules\wechat\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%wechat_menu}}".
 *
 * @property integer $id
 * @property string $w_id
 * @property integer $pid
 * @property integer $level
 * @property string $code
 * @property string $name
 * @property integer $type
 * @property string $key
 * @property string $url
 * @property integer $created_at
 * @property integer $updated_at
 */
class Menu extends \app\core\db\ActiveRecord
{

    const TYPE_URL = 1;
    const TYPE_KEY = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wechat_menu}}';
    }

    public function behaviors()
    {
        return [
            [
                'class'=>TimestampBehavior::className(),
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid', 'level', 'created_at', 'updated_at', 'wid'], 'integer'],
            [['pid', 'name','wid'], 'required'],
            [['code', 'name', 'url'], 'string', 'max' => 255],
            [['key'], 'string', 'max' => 128],
            [['type'], 'default', 'value'=>self::TYPE_URL]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pid' => '父菜单',
            'level' => '层级',
            'code' => '标识',
            'name' => '菜单名',
            'type' => '类型',
            'key' => '键',
            'url' => '网址',
            'created_at' => '添加时间',
            'updated_at' => '更新时间',
        ];
    }

    static public function typeMap($type=null)
    {
        $map = [
            self::TYPE_URL => '页面',
            self::TYPE_KEY => '事件'
        ];

        if (is_null($type)) {
            return $map;
        }
        return $map[$type];
    }

    static public function getWechatMenus($wid, $main_id)
    {
        $menus = self::find()
                    ->where(['wid'=>$wid])
                    ->andWhere(['main_id'=>$main_id])
                    ->orderBy('id asc')
                    ->asArray()
                    ->all();

        $menus = \app\core\helpers\ArrayHelper::recursion($menus,0,1);

        return $menus;
    }

    public static function menusMap($wid,$main_id, $type = 1)
    {
        $menus = self::find()
                    ->where(['wid'=>$wid])
                    ->andWhere(['main_id'=>$main_id])
                    ->orderBy('id asc')
                    ->asArray()
                    ->all();
                    
        $menus = \app\core\helpers\ArrayHelper::recursion($menus,0,2);

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
}
