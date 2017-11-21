<?php

namespace app\modules\mess\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\modules\user\models\User;
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
            [['op_id', 'price', 'user_id'], 'required'],
            [['price'], 'number'],
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
            'user_id' => '用户名',
            'op_id' => '操作人',
            'price' => '充值金额',
            'created_at' => '充值时间',
            'user.username' => '账户',
            'op.username' => '操作人'
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id'=>'user_id']);
    }

    public function getOp()
    {
        return $this->hasOne(User::className(), ['id'=>'op_id']);
    }
}
