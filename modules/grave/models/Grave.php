<?php

namespace app\modules\grave\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\core\traits\TreeTrait;
/**
 * This is the model class for table "{{%grave}}".
 *
 * @property integer $id
 * @property integer $pid
 * @property integer $level
 * @property string $code
 * @property string $name
 * @property integer $thumb
 * @property string $intro
 * @property double $area_totle
 * @property double $area_use
 * @property string $price
 * @property integer $status
 * @property integer $user_id
 * @property integer $sort
 * @property integer $is_leaf
 * @property integer $created_at
 */
class Grave extends \app\core\db\ActiveRecord
{
    
    use TreeTrait;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%grave}}';
    }

    public function behaviors()
    {
        return [
            [
                'class'=>TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at']
                ]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid', 'level', 'thumb', 'status', 'user_id', 'sort', 'is_leaf', 'created_at'], 'integer'],
            [['intro'], 'string'],
            [['area_totle', 'area_use', 'price'], 'number'],
            [['name'], 'required'],
            [['code', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pid' => 'Pid',
            'level' => 'Level',
            'code' => 'Code',
            'name' => '墓区名',
            'thumb' => '缩略图',
            'intro' => '介绍',
            'area_totle' => '总面积',
            'area_use' => '使用面积',
            'price' => '墓基价',
            'status' => '状态',
            'user_id' => '添加人',
            'sort' => '排序',
            'is_leaf' => 'Is Leaf',
            'created_at' => '添加时间',
        ];
    }
}
