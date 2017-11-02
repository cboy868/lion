<?php

namespace app\modules\order\models;

use Yii;
use app\core\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use app\modules\user\models\User;

/**
 * This is the model class for table "{{%order_pay}}".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $order_no
 * @property integer $trade_no
 * @property string $total_fee
 * @property string $total_pay
 * @property integer $pay_method
 * @property integer $pay_result
 * @property integer $mid
 * @property integer $wechat_uid
 * @property string $paid_at
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $checkout_at
 * @property string $note
 * @property integer $status
 */
class Refund extends \app\core\db\ActiveRecord
{

    //-1 审不通过，1待审 2审通过 3已退

    const PRO_NOPASS = -1;
    const PRO_WAIT = 1;
    const PRO_PASS = 2;
    const PRO_OK   = 3;


    const EVENT_AFTER_NOPASS = 'afterNopass';
    const EVENT_AFTER_PASS = 'afterPass';
    const EVENT_AFTER_FEEOK = 'afterFee';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order_refund}}';
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
            [['order_id', 'wechat_uid', 'progress', 'created_at', 'updated_at', 'status', 'op_id', 'user_id', 'tid'], 'integer'],
            [['fee'], 'number'],
            [['intro', 'note'], 'string'],
            [['checkout_at'], 'safe'],
            [['fee'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => '订单id',
            'user_id' => '用户id',
            'fee' => '退款金额',
            'progress' => '退款状态',
            'intro' => '退款内容',
            'note' => '简单描述',
            'checkout_at' => '对账时间',
            'created_at' => '退款创建时间',
            'updated_at' => 'Updated At',
            'status' => 'Status',
            'pro' => '进度'
        ];
    }

    public function verify()
    {

        $this->progress = self::PRO_PASS;

        $connection = Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try {
            $this->save();
            $intro = json_decode($this->intro);
            if (is_array($intro)) {
                $rels = ArrayHelper::getColumn($intro, 'rel_id');
                $connection->createCommand()->update(OrderRel::tableName(), ['is_refund' => 1], ['id'=>$rels])->execute();
            }

            $order = Order::findOne($this->order_id);

            $order->refund();

            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            return $e->getMessages();
        }

        return false;









        // if ($this->save()) {
        //     // $this->trigger(self::EVENT_AFTER_PASS);
        //     $intro = json_decode($this->intro);
        //     $rels = [];
        //     if (is_array($intro)) {
        //         $rels = ArrayHelper::getColumn($intro, 'rel_id');
        //         $connection = Yii::$app->db;
        //         $connection->createCommand()->update(OrderRel::tableName(), ['is_refund' => 1], ['id'=>$rels])->execute();
        //     }
        //     return true;
        // }
        // return false;
    }

    public function noVerify()
    {
        $this->progress = self::PRO_NOPASS;
        if ($this->save()) {
            //$this->trigger(self::EVENT_AFTER_NOPASS);
            return true;
        }
        return false;
    }

    public function feeOk()
    {
        $this->progress = self::PRO_OK;
        if ($this->save()) {
            //$this->trigger(self::EVENT_AFTER_FEEOK);

            return true;
        }
        return false;
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function pros($pro = null)
    {
        $pros = [
            self::PRO_WAIT => "待审",
            self::PRO_PASS => "审核通过",
            self::PRO_OK => "退款完成",
            self::PRO_NOPASS => '审核不通过',
        ];

        if ($pro) {
            return $pros[$pro];
        }

        return $pros;
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {//通过之后还要处理订单之类的东西
            //退款申请之后，加一些短信提醒之类的东西
        }
    }

    public function getPro()
    {
        return self::pros($this->progress);
    }
}
