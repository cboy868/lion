<?php

namespace app\core\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%op_log}}".
 *
 * @property integer $id
 * @property string $route
 * @property string $description
 * @property integer $created_at
 * @property integer $user_id
 */
class OpLog extends \app\core\db\ActiveRecord
{

    const ACTION_ADD = 1;
    const ACTION_DEL = 2;
    const ACTION_UPDATE = 3;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%op_log}}';
    }

    public static function getActions($action=null)
    {
        $a = [
            self::ACTION_ADD => '增',
            self::ACTION_DEL => '删',
            self::ACTION_UPDATE => '改'
        ];

        if ($action === null) {
            return $a;
        }

        return isset($a[$action]) ? $a[$action] : '';

    }

    public function getAc()
    {
        return self::getActions($this->action);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description','table_name', 'ip'], 'string'],
            [['description','table_name', 'action'], 'required'],
            [['created_at', 'user_id'], 'integer'],
            [['route'], 'string', 'max' => 255],
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
            'route' => '操作路径',
            'description' => '操作明细',
            'created_at' => '操作时间',
            'user_id' => '用户名',
            'user.username' => '操作人',
            'table_name' => '表',
            'ip' => 'IP地址',
            'ac' => '操作'
        ];
    }

    public function getUser()
    {
        return $this->hasOne(\app\modules\user\models\User::className(),['id'=>'user_id']);
    }
}
