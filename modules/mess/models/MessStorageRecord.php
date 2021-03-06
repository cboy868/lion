<?php

namespace app\modules\mess\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%mess_storage_record}}".
 *
 * @property integer $id
 * @property integer $supplier_id
 * @property integer $mess_id
 * @property integer $food_id
 * @property double $number
 * @property string $unit_price
 * @property string $count_price
 * @property integer $type
 * @property integer $created_at
 */
class MessStorageRecord extends \app\core\db\ActiveRecord
{
    const TYPE_IN = 1;
    const TYPE_OUT = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mess_storage_record}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['supplier_id', 'mess_id', 'food_id', 'type'], 'integer'],
            [['mess_id', 'food_id', 'unit_price', 'count_price', 'dt'], 'required'],
            [['number', 'unit_price', 'count_price'], 'number'],
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
            'supplier_id' => '供应商',
            'mess_id' => '食堂',
            'food_id' => '原材料',
            'number' => '数量',
            'unit_price' => '单价',
            'count_price' => '总价',
            'type' => '类型',
            'dt' => '进货日期',
            'created_at' => 'Created At',
        ];
    }

    public function getMess()
    {
        return $this->hasOne(Mess::className(), ['id'=>'mess_id']);
    }

    public function getFood()
    {
        return $this->hasOne(MessFood::className(), ['id'=>'food_id']);
    }

    public function getSupplier()
    {
        return $this->hasOne(MessSupplier::className(), ['id'=>'supplier_id']);
    }
}
