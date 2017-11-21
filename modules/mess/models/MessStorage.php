<?php

namespace app\modules\mess\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%mess_stock_log}}".
 *
 * @property integer $id
 * @property integer $mess_id
 * @property integer $food_id
 * @property double $num
 * @property string $unit_price
 * @property string $count_price
 * @property integer $created_at
 */
class MessStorage extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mess_storage}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mess_id', 'food_id'], 'required'],
            [['mess_id', 'food_id', 'created_at'], 'integer'],
            [['num'], 'number'],
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
            'mess_id' => '食堂',
            'food_id' => '材料',
            'num' => '数量',
        ];
    }

    public static function up($mess_id, $food_id,$num,$type)
    {
        $model = self::find()->where(['mess_id'=>$mess_id,'food_id'=>$food_id])->one();

        if (!$model) {
            $model = new self();
            $model->mess_id = $mess_id;
            $model->food_id = $food_id;
            $model->num = 0;
        }

        $model->num += $type == MessStorageRecord::TYPE_IN ? $num : -$num;
        return $model->save();
    }


    public function getMess()
    {
        return $this->hasOne(Mess::className(), ['id'=>'mess_id']);
    }

    public function getFood()
    {
        return $this->hasOne(MessFood::className(), ['id'=>'food_id']);
    }

}
