<?php

namespace app\modules\order\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\modules\user\models\User;
/**
 * This is the model class for table "order_delay".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $user_id
 * @property string $price
 * @property string $pre_dt
 * @property string $pay_dt
 * @property string $note
 * @property integer $created_by
 * @property integer $is_verified
 * @property integer $verified_by
 * @property integer $verified_at
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 */
class Delay extends \app\core\db\ActiveRecord
{

    const VERIFIED_OK = 1;
    const VERIFIED_INIT = 0;
    const VERIFIED_NO = -1;


    const EVENT_AFTER_CREATE = 'afterCreate';
    const EVENT_AFTER_VERIFY= 'afterVerify'; //欠款申请之后，同样会有一些短信、任务之类的东西
    const EVENT_AFTER_NOVERIFY= 'afterNoVerify'; //欠款申请之后，同样会有一些短信、任务之类的东西
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_delay';
    }

    public function behaviors()
    {
        return [
            [
                'class'=>TimestampBehavior::className(),
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'user_id', 'created_by', 'is_verified', 'verified_by', 'verified_at', 'created_at', 'updated_at', 'status', 'op_id'], 'integer'],
            [['price'], 'number'],
            [['pre_dt', 'pay_dt'], 'safe'],
            [['note'], 'string'],
            [['pre_dt', 'order_id', 'price'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => '订单ID',
            'user_id' => 'User ID',
            'op_id' => '操作员',
            'price' => '延期金额',
            'pre_dt' => '预付款日期',
            'pay_dt' => '实际支付时间',
            'note' => '备注',
            'created_by' => '申请人',
            'is_verified' => '审批结果',//0初始 1通过 -1审核不通过
            'verified_by' => '审批人',
            'verified_at' => '审批时间',
            'created_at' => '添加时间',
            'updated_at' => '更新时间',
            'status' => '状态', //
        ];
    }

    public function create($order)
    {
        $data = [
            'user_id' => $order->user_id,
            'order_id' => $order->id,
            'price' => $order->getRemain(),
            'op_id' => Yii::$app->user->id,
        ];

        $this->load($data, '');


        if ($this->save()) {
            $event = new DelayEvent(['progress' => Order::PRO_DELAY]);
            $this->trigger(self::EVENT_AFTER_CREATE, $event);
            return true;
        }

        return false;
    }


    public function verify()
    {
        $this->is_verified = self::VERIFIED_OK;
        if ($this->save()) {
            $this->trigger(self::EVENT_AFTER_VERIFY);
            return true;
        }

        return false;
    }

    public function noVerify()
    {
        $this->is_verified = self::VERIFIED_NO;
        if ($this->save()) {
            $this->trigger(self::EVENT_AFTER_NOVERIFY);
            return true;
        }
        return false;
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getOp()
    {
        return $this->hasOne(User::className(), ['id' => 'op_id']);
    }

    public function getVerfyUser()
    {
        return $this->hasOne(User::className(), ['id' => 'verified_by']);
    }

    /**
     * 取审批结果
     */
    public static function getVerfy($verfy=null)
    {
        $ver = [
            self::VERIFIED_INIT => '待审批',
            self::VERIFIED_NO => '未通过',
            self::VERIFIED_OK => '审批通过'
        ];

        if ($verfy === null) {
            return $ver;
        }

        return $ver[$verfy];
    }


}
