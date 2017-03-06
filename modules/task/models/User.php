<?php

namespace app\modules\task\models;

use Yii;

/**
 * This is the model class for table "{{%task_user}}".
 *
 * @property integer $id
 * @property integer $info_id
 * @property integer $user_id
 * @property integer $default
 */
class User extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%task_user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['info_id', 'user_id', 'default'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'info_id' => 'Info ID',
            'user_id' => 'User ID',
            'default' => 'Default',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(\app\modules\user\models\User::className(),['id'=>'user_id']);
    }
}
