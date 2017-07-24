<?php

namespace app\modules\grave\models;

use Yii;

/**
 * This is the model class for table "{{%grave_withdraw}}".
 *
 * @property integer $id
 * @property integer $guide_id
 * @property integer $user_id
 * @property integer $tomb_id
 * @property integer $current_tomb_id
 * @property integer $refund_id
 * @property string $ct_name
 * @property string $ct_mobile
 * @property string $ct_card
 * @property string $ct_relation
 * @property string $reson
 * @property string $price
 * @property integer $in_tomb_id
 * @property string $note
 * @property integer $status
 * @property integer $updated_at
 * @property integer $created_at
 */
class Withdraw extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%grave_withdraw}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['guide_id', 'user_id', 'tomb_id', 'current_tomb_id', 'updated_at', 'created_at'], 'required'],
            [['guide_id', 'user_id', 'tomb_id', 'current_tomb_id', 'refund_id', 'in_tomb_id', 'status', 'updated_at', 'created_at'], 'integer'],
            [['reson', 'note'], 'string'],
            [['price'], 'number'],
            [['ct_name'], 'string', 'max' => 200],
            [['ct_mobile'], 'string', 'max' => 20],
            [['ct_card', 'ct_relation'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'guide_id' => 'Guide ID',
            'user_id' => 'User ID',
            'tomb_id' => 'Tomb ID',
            'current_tomb_id' => 'Current Tomb ID',
            'refund_id' => 'Refund ID',
            'ct_name' => '联系人',
            'ct_mobile' => '联系人手机号',
            'ct_card' => '联系人身份证',
            'ct_relation' => '与使用人关系',
            'reson' => '退墓 原因',
            'price' => '退款',
            'in_tomb_id' => 'In Tomb ID',
            'note' => '备注',
            'status' => '状态 ',
            'updated_at' => '修改时间',
            'created_at' => '添加时间',
        ];
    }

    public function getTomb()
    {
        return $this->hasOne(Tomb::className(), ['id'=>'tomb_id']);
    }
}
