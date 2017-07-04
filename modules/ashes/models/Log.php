<?php

namespace app\modules\ashes\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%ashes_log}}".
 *
 * @property integer $id
 * @property integer $action
 * @property string $box_id
 * @property string $area_id
 * @property string $tomb_id
 * @property string $deads
 * @property string $bury_date
 * @property integer $out_way
 * @property string $op_id
 * @property string $save_user
 * @property string $out_user
 * @property string $save_time
 * @property string $out_time
 * @property string $note
 * @property string $contact
 * @property string $mobile
 * @property string $relation
 * @property integer $status
 * @property integer $created_at
 */
class Log extends \app\core\db\ActiveRecord
{
    const ACTION_IN = 1;
    const ACTION_OUT = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ashes_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['action', 'box_id', 'area_id', 'tomb_id', 'out_way', 'op_id', 'status', 'created_at'], 'integer'],
            [['box_id', 'area_id', 'op_id', 'save_user', 'contact', 'mobile'], 'required'],
            [['bury_date', 'save_time', 'out_time'], 'safe'],
            [['note'], 'string'],
            [['deads', 'save_user', 'out_user', 'contact', 'mobile', 'relation'], 'string', 'max' => 255],
        ];
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
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'action' => '动作',
            'box_id' => '柜子id',
            'area_id' => '架区id',
            'tomb_id' => '墓位id',
            'deads' => '使用人',
            'bury_date' => '安葬时间',
            'out_way' => '取盒方式',
            'op_id' => '操作人',
            'op_time' => '操作时间',
            'save_user' => '存入人',
            'out_user' => '取出人',
            'save_time' => '存入时间',
            'out_time' => '取出时间',
            'note' => '备注',
            'contact' => '联系人',
            'mobile' => '手机号',
            'relation' => '关系',
            'status' => '状态',
            'created_at' => '添加时间',
        ];
    }
}
