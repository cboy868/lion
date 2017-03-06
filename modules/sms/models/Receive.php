<?php

namespace app\modules\sms\models;

use Yii;

/**
 * This is the model class for table "{{%sms_receive}}".
 *
 * @property integer $id
 * @property string $mobile
 * @property string $msg
 * @property integer $status
 * @property integer $created_at
 */
class Receive extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sms_receive}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['msg'], 'string'],
            [['status', 'created_at'], 'integer'],
            [['created_at'], 'required'],
            [['mobile'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mobile' => 'Mobile',
            'msg' => 'Msg',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }
}
