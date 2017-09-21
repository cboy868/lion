<?php

namespace app\modules\grave\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%grave_free}}".
 *
 * @property integer $id
 * @property string $title
 * @property integer $bury_type
 * @property string $bury_date
 * @property integer $max_num
 * @property string $note
 * @property string $op_user
 * @property string $op_mobile
 * @property integer $status
 * @property integer $created_at
 * @property integer $op_id
 * @property string $stage
 */
class Free extends \app\core\db\ActiveRecord
{
    const TYPE_HUATAN = 1; //花坛
    const TYPE_CAOPING = 2; //草坪
    const TYPE_SHUI = 3; //水

    const STATUS_FINISH = 2;//活动完成


    public static function types($type=null)
    {
        $t = [
            self::TYPE_HUATAN => '花坛葬',
            self::TYPE_CAOPING=> '草坪葬',
            self::TYPE_SHUI => '水葬'
        ];


        return $type === null ? $t : $t[$type];
    }

    public function getType()
    {
        return self::types($this->bury_type);
    }

    public static function status($status = null)
    {
        $s = [
            self::STATUS_DEL => '删除',
            self::STATUS_NORMAL => '组织阶段',
            self::STATUS_FINISH =>'活动完成'
        ];

        if ($status === null) {
            return $s;
        }

        return $s[$status];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%grave_free}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'bury_type', 'note'], 'required'],
            [['bury_type', 'max_num', 'status', 'created_at', 'op_id'], 'integer'],
            [['bury_date'], 'safe'],
            [['note'], 'string'],
            [['title'], 'string', 'max' => 200],
            [['op_user'], 'string', 'max' => 100],
            [['op_mobile'], 'string', 'max' => 20],
            [['stage'], 'string', 'max' => 50],
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
            'title' => '免费葬标题期次',
            'bury_type' => '免费葬类型',
            'bury_date' => '免费葬日期',
            'max_num' => '最大安葬数量',
            'note' => '本次免费葬介绍',
            'op_user' => '负责人',
            'op_mobile' => '联系方式',
            'status' => '状态',
            'created_at' => '添加时间',
            'op_id' => '负责人id',
            'stage' => '期次',
            'type'=> '免费葬方式',
            'statusText'=>'状态'
        ];
    }

    public static function sel($hasold=false,$limit=null)
    {
        $query = self::find();

        if (!$hasold) {
            $query->where(['status'=>self::STATUS_NORMAL]);
        } else {
            $query->where(['status'=>[self::STATUS_NORMAL, self::STATUS_FINISH]]);
        }


        if ($limit !== null) {
            $query->limit($limit);
        }

        $total = $query->orderBy('id desc')->all();

        return ArrayHelper::map($total, 'id', 'title');

    }
}
