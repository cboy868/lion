<?php

namespace app\modules\grave\models;

use app\modules\user\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%grave_free_dead}}".
 *
 * @property integer $id
 * @property string $contact_user
 * @property string $contact_mobile
 * @property string $dead
 * @property string $relation
 * @property integer $free_id
 * @property integer $is_confirm
 * @property integer $op_user
 * @property integer $status
 * @property integer $created_at
 * @property string $confirm_at
 * @property string $note
 */
class FreeDead extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%grave_free_dead}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['contact_user', 'contact_mobile', 'dead', 'note'], 'required'],
            [['free_id', 'is_confirm', 'op_user', 'status', 'created_at'], 'integer'],
            [['confirm_at', 'user_id'], 'safe'],
            [['note'], 'string'],
            [['contact_user'], 'string', 'max' => 100],
            [['contact_mobile'], 'string', 'max' => 20],
            [['dead', 'relation'], 'string', 'max' => 200],
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
            'contact_user' => '联系人',
            'contact_mobile' => '联系人手机号',
            'dead' => '逝者',
            'relation' => '关系',
            'free_id' => '免费葬期次',
            'is_confirm' => '是否已确认过',
            'op_user' => '操作人',
            'status' => '状态',
            'created_at' => '添加时间',
            'confirm_at' => '操作时间',
            'note' => '备注',
            'user_id' => '办理人账号'
        ];
    }

    public function getFree()
    {
        return $this->hasOne(Free::className(), ['id'=>'free_id']);
    }

    public function getOp()
    {
        return $this->hasOne(User::className(),['id'=>'op_user']);
    }
}
