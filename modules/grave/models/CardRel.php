<?php

namespace app\modules\grave\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%grave_card_rel}}".
 *
 * @property integer $id
 * @property integer $card_id
 * @property integer $tomb_id
 * @property string $start
 * @property string $end
 * @property integer $order_id
 * @property string $price
 * @property integer $total
 * @property integer $num
 * @property string $customer_name
 * @property string $mobile
 * @property integer $created_by
 * @property integer $created_at
 */
class CardRel extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%grave_card_rel}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['card_id', 'tomb_id', 'start', 'end'], 'required'],
            [['card_id', 'tomb_id', 'order_rel_id', 'total', 'num', 'created_by', 'created_at'], 'integer'],
            [['start', 'end'], 'safe'],
            [['price'], 'number'],
            [['customer_name'], 'string', 'max' => 50],
            [['mobile'], 'string', 'max' => 20],
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
            'card_id' => '主表id',
            'tomb_id' => '墓位id',
            'start' => '起始',
            'end' => '截止',
            'order_rel_id' => '订单id',
            'price' => '价格',
            'total' => '总年数',
            'num' => '期数',
            'customer_name' => '客户名',
            'mobile' => '手机号',
            'created_by' => '操作人',
            'created_at' => '添加时间',
        ];
    }

    /**
     * @name 初始化
     */
    public static function initRel($card, $order_rel_id)
    {
        $rels = self::find()->where(['card_id'=>$card->id])->all();
        if ($rels) {
            return $rels;
        }

        $order_rel = \app\modules\grave\models\OrderRel::findOne($order_rel_id);
        $customer = $order_rel->tomb->customer;

        $rel = new self();
        $data = [
            'card_id' => $card->id,
            'tomb_id' => $card->tomb_id,
            'start' => $card->start,
            'end' => $card->end,
            'num' =>1,
            'total' => $card->total,
            'created_by' => $card->created_by,
            'order_rel_id' =>$order_rel_id,
            'price' => $order_rel->price,
            'customer_name' => isset($customer->name)? $customer->name : '',
            'mobile' => isset($customer->mobile)? $customer->mobile : '',
        ];

        $rel->load($data, '');
        if ($rel->save()===false) {
            Yii::error('墓证明细保存失败', __METHOD__);
            return false;
        }

        return $rel;
    }

    public function afterSave($insert, $changedAttributes)
    {
        $tomb_id = $this->tomb_id;
        $min = self::find()->where(['tomb_id'=>$tomb_id])->min('start');
        $max = self::find()->where(['tomb_id'=>$tomb_id])->max('end');

        $this->card->start = $min;
        $this->card->end = $max;
        $this->card->total = date('Y', strtotime($max)) - date('Y', strtotime($min));
        return $this->card->save();
    }

    public function afterDelete()
    {
        $tomb_id = $this->tomb_id;
        $min = self::find()->where(['tomb_id'=>$tomb_id])->min('start');
        $max = self::find()->where(['tomb_id'=>$tomb_id])->max('end');

        $this->card->start = $min;
        $this->card->end = $max;
        $this->card->total = date('Y', strtotime($max)) - date('Y', strtotime($min));
        return $this->card->save();
    }

    public static function afterPay($order_rel_id)
    {

        $rel = OrderRel::findOne($order_rel_id);
        $mcard = Card::find()->where(['tomb_id'=>$rel->tid])->one();

        if (!$mcard) {
            return ;
        }

        $card = new self;

        $params = Yii::$app->getModule('grave')->params['tomb_card'];

        $card->card_id = $mcard->id;
        $card->tomb_id = $rel->tid;
        $card->price = $rel->price;
        $card->num = $rel->num;
        $card->order_rel_id = $rel->id;
        $card->total =  $params['years']* $rel->num;
        $card->start = $mcard->end;
        $card->end = (substr($card->start, 0, 4) + $card->total) . substr($card->start, 4);

        return $card->save();
    }

    public function getBy()
    {
        return $this->hasOne(\app\modules\user\models\User::className(),['id'=>'created_by']);
    }

    public function getTomb()
    {
        return $this->hasOne(\app\modules\grave\models\Tomb::className(),['id'=>'tomb_id']);
    }

    public function getCard()
    {
        return $this->hasOne(\app\modules\grave\models\Card::className(),['id'=>'card_id']);
    }
}
