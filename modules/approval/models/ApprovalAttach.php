<?php

namespace app\modules\approval\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%approval_attach}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $url
 * @property integer $created_at
 * @property integer $status
 * @property string $ext
 */
class ApprovalAttach extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%approval_attach}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['approval_id', 'title', 'url'], 'required'],
            [['approval_id', 'created_at', 'status'], 'integer'],
            [['title', 'url', 'ext'], 'string', 'max' => 255],
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
            'approval_id' => 'Approve ID',
            'title' => '附件名',
            'url' => '地址',
            'created_at' => '添加时间',
            'status' => '状态',
            'ext' => '后缀',
        ];
    }

    public function getApproval()
    {
        return $this->hasOne(Approval::className(),['id' => 'approval_id']);
    }
}
