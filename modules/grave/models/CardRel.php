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
            [['card_id', 'tomb_id', 'order_id', 'total', 'num', 'created_by', 'created_at'], 'integer'],
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
            'order_id' => '订单id',
            'price' => '价格',
            'total' => '总年数',
            'num' => '期数',
            'customer_name' => '客户名',
            'mobile' => '手机号',
            'created_by' => '操作人',
            'created_at' => '添加时间',
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        $tomb_id = $this->tomb_id;
        $min = self::find()->where(['tomb_id'=>$tomb_id])->min('start');
        $max = self::find()->where(['tomb_id'=>$tomb_id])->max('end');

        $this->card->start = $min;
        $this->card->end = $max;
        return $this->card->save();
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
