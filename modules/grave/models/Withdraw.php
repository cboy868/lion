<?php

namespace app\modules\grave\models;

use app\modules\analysis\models\Settlement;
use app\modules\user\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%grave_withdraw}}".
 *
 * @property integer $id
 * @property integer $guide_id
 * @property integer $user_id
 * @property integer $tomb_id
 * @property integer $current_tomb_id
 * @property integer $refund_id
 * @property string $ct_name
 * @property string $ct_mobile
 * @property string $ct_card
 * @property string $ct_relation
 * @property string $reson
 * @property string $price
 * @property integer $in_tomb_id
 * @property string $note
 * @property integer $status
 * @property integer $updated_at
 * @property integer $created_at
 */
class Withdraw extends \app\core\db\ActiveRecord
{
    const TYPE_DING_REFUND = 1;//订金退墓
    const TYPE_DING_CHANGE = 3;//订金换墓
    const TYPE_ALL_REFUND = 5;//全款退墓
    const TYPE_REFUND_IN = 7;//退墓迁本园

    const TYPE_DING_REFUND_OK = 2;//订金退墓
    const TYPE_DING_CHANGE_OK = 4;//订金换墓
    const TYPE_ALL_REFUND_OK = 6;//全款退墓
    const TYPE_REFUND_IN_OK = 8;//退墓迁本园

    const TYPE_DING_REFUND_NO = -2;//订金退墓
    const TYPE_DING_CHANGE_NO = -4;//订金换墓
    const TYPE_ALL_REFUND_NO = -6;//全款退墓
    const TYPE_REFUND_IN_NO = -8;//退墓迁本园



    public static function types($type=null)
    {
        $t = [
            self::TYPE_DING_REFUND => '订金退墓',
//            self::TYPE_DING_CHANGE => '订金换墓',
            self::TYPE_ALL_REFUND  => '全款退墓',
//            self::TYPE_REFUND_IN   => '园内换墓',

            self::TYPE_DING_REFUND_OK => '订金退墓完成',
//            self::TYPE_DING_CHANGE_OK => '订金换墓完成',
            self::TYPE_ALL_REFUND_OK  => '全款退墓完成',
//            self::TYPE_REFUND_IN_OK   => '园内换墓完成',

            self::TYPE_DING_REFUND_OK => '订金退墓未通过',
            self::TYPE_ALL_REFUND_NO  => '全款退墓未通过',
        ];

        if ($type !== null && isset($t[$type])) {
            return $t[$type];
        }

        return $t;
    }

    public function getType()
    {
        return self::types($this->status);
    }


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%grave_withdraw}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['guide_id', 'user_id', 'tomb_id'], 'required'],
            [['guide_id', 'user_id', 'tomb_id', 'current_tomb_id', 'refund_id',
                'in_tomb_id', 'status', 'updated_at', 'created_at'], 'integer'],
            [['reson', 'note'], 'string'],
            [['price'], 'number'],
            [['ct_name'], 'string', 'max' => 200],
            [['ct_mobile'], 'string', 'max' => 20],
            [['ct_card', 'ct_relation'], 'string', 'max' => 100],
        ];
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
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'guide_id' => 'Guide ID',
            'user_id' => 'User ID',
            'tomb_id' => 'Tomb ID',
            'current_tomb_id' => 'Current Tomb ID',
            'refund_id' => 'Refund ID',
            'ct_name' => '退墓办理人',
            'ct_mobile' => '办理人手机号',
            'ct_card' => '办理人身份证',
            'ct_relation' => '与使用人关系',
            'reson' => '退墓 原因',
            'price' => '退款金额',
            'in_tomb_id' => '换至墓位',
            'note' => '备注',
            'status' => '状态 ',
            'updated_at' => '修改时间',
            'created_at' => '添加时间',
            'guide.username' => '导购员',
            'type' => '退墓类型'
        ];
    }

    public function verify($type)
    {

        $this->status = $type;
        $tomb = $this->tomb;

        $connection = Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try {
            $newTomb = $tomb->copy($this->tomb_id);
            $tomb->status = Tomb::STATUS_RETURN;
            $tomb->new_id = $newTomb->id;
            $tomb->save();


            $this->current_tomb_id = $newTomb->id;
            $this->save();

            Settlement::refundTomb($this);

            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            return $e->getMessages();
        }

        return false;
    }

    public function noVerify($type)
    {
        $this->status = $type;
        if ($this->save()) {
            //$this->trigger(self::EVENT_AFTER_NOPASS);
            return true;
        }
        return false;
    }

    public function getTomb()
    {
        return $this->hasOne(Tomb::className(), ['id'=>'tomb_id']);
    }
    public function getInTomb()
    {
        return $this->hasOne(Tomb::className(), ['id'=>'in_tomb_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id'=>'user_id']);
    }

    public function getGuide()
    {
        return $this->hasOne(User::className(), ['id'=>'guide_id']);
    }
}
