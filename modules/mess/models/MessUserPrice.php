<?php

namespace app\modules\mess\models;

use app\modules\user\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%mess_user_price}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $price
 * @property integer $created_at
 * @property integer $updated_at
 */
class MessUserPrice extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mess_user_price}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'price'], 'required'],
            [['user_id', 'created_at', 'updated_at','status'], 'integer'],
            [['price'], 'number'],
        ];
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
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户',
            'price' => '总金额',
            'created_at' => '添加时间',
            'updated_at' => 'Updated At',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id'=>'user_id']);
    }
}
