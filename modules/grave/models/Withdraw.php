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
            'ct_name' => 'Ct Name',
            'ct_mobile' => 'Ct Mobile',
            'ct_card' => 'Ct Card',
            'ct_relation' => 'Ct Relation',
            'reson' => 'Reson',
            'price' => 'Price',
            'in_tomb_id' => 'In Tomb ID',
            'note' => 'Note',
            'status' => 'Status',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }
}
