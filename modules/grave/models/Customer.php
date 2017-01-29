<?php

namespace app\modules\grave\models;

use Yii;

/**
 * This is the model class for table "{{%grave_customer}}".
 *
 * @property integer $id
 * @property integer $tomb_id
 * @property integer $user_id
 * @property string $name
 * @property string $phone
 * @property string $mobile
 * @property string $email
 * @property string $second_ct
 * @property string $second_mobile
 * @property string $units
 * @property string $relation
 * @property integer $is_vip
 * @property string $vip_desc
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 */
class Customer extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%grave_customer}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tomb_id', 'user_id'], 'required'],
            [['tomb_id', 'user_id', 'is_vip', 'created_at', 'updated_at', 'status'], 'integer'],
            [['vip_desc'], 'string'],
            [['name'], 'string', 'max' => 200],
            [['phone', 'mobile', 'second_mobile'], 'string', 'max' => 20],
            [['email', 'second_ct', 'relation'], 'string', 'max' => 100],
            [['units'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tomb_id' => 'Tomb ID',
            'user_id' => 'User ID',
            'name' => 'Name',
            'phone' => 'Phone',
            'mobile' => 'Mobile',
            'email' => 'Email',
            'second_ct' => 'Second Ct',
            'second_mobile' => 'Second Mobile',
            'units' => 'Units',
            'relation' => 'Relation',
            'is_vip' => 'Is Vip',
            'vip_desc' => 'Vip Desc',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }
}
