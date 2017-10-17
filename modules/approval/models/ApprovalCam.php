<?php

namespace app\modules\approval\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%approval_cam}}".
 *
 * @property integer $id
 * @property integer $approval_id
 * @property integer $pay_type
 * @property string $cam_no
 * @property integer $op_id
 * @property string $amount
 * @property string $paid
 * @property string $note
 * @property integer $created_at
 * @property integer $status
 * @property integer $cam_user
 */
class ApprovalCam extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%approval_cam}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['approval_id', 'amount', 'paid', 'note'], 'required'],
            [['approval_id', 'pay_type', 'op_id', 'created_at', 'status', 'cam_user'], 'integer'],
            [['amount', 'paid'], 'number'],
            [['note'], 'string'],
            [['cam_no'], 'string', 'max' => 100],
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
            'approval_id' => 'Approval ID',
            'pay_type' => '支付方式 ',
            'cam_no' => '支票号',
            'op_id' => '操作人',
            'amount' => '金额',
            'paid' => '已支付',
            'note' => '备注',
            'created_at' => '添加时间',
            'status' => '状态',
            'cam_user' => '领取人',
        ];
    }

    public function getApproval()
    {
        return $this->hasOne(Approval::className(),['id' => 'approval_id']);
    }
}
