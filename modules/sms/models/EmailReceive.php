<?php

namespace app\modules\sms\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%email_receive}}".
 *
 * @property integer $id
 * @property string $email
 * @property string $msg
 * @property integer $status
 * @property integer $created_at
 */
class EmailReceive extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%email_receive}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['msg'], 'string'],
            [['status', 'created_at'], 'integer'],
            [['email'], 'required'],
            [['email'], 'string', 'max' => 20],
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
            'email' => 'Email',
            'msg' => 'Msg',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }
}
