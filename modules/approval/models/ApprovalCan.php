<?php

namespace app\modules\approval\models;

use app\modules\user\models\User;
use Yii;

/**
 * This is the model class for table "{{%approval_can}}".
 *
 * @property integer $process_id
 * @property integer $user_id
 */
class ApprovalCan extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%approval_can}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['process_id', 'user_id'], 'required'],
            [['process_id', 'user_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'process_id' => 'Process ID',
            'user_id' => 'User ID',
        ];
    }

    public function getProcess()
    {
        return $this->hasOne(ApprovalProcess::className(), ['id'=>'process_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id'=>'user_id']);
    }
}
