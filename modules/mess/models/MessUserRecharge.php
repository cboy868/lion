<?php

namespace app\modules\mess\models;

use Yii;

/**
 * This is the model class for table "{{%mess_user_recharge}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $op_id
 * @property string $price
 * @property integer $created_at
 */
class MessUserRecharge extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mess_user_recharge}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'op_id', 'created_at'], 'integer'],
            [['op_id', 'price', 'created_at'], 'required'],
            [['price'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'op_id' => 'Op ID',
            'price' => 'Price',
            'created_at' => 'Created At',
        ];
    }
}
