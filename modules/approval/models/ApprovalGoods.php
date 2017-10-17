<?php

namespace app\modules\approval\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%approval_goods}}".
 *
 * @property integer $id
 * @property integer $approval_id
 * @property string $title
 * @property string $intro
 * @property string $unit
 * @property integer $num
 * @property string $unit_price
 * @property integer $created_at
 * @property integer $status
 */
class ApprovalGoods extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%approval_goods}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['approval_id', 'title', 'intro', 'unit', 'num', 'unit_price', 'created_at'], 'required'],
            [['approval_id', 'num', 'created_at', 'status'], 'integer'],
            [['intro'], 'string'],
            [['title', 'unit', 'unit_price'], 'string', 'max' => 255],
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
            'title' => '标题',
            'intro' => '物品介绍',
            'unit' => '单位',
            'num' => '数量',
            'unit_price' => '单价',
            'created_at' => '添加时间',
            'status' => '状态',
        ];
    }

    public function getApproval()
    {
        return $this->hasOne(Approval::className(),['id' => 'approval_id']);
    }
}
