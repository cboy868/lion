<?php

namespace api\common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\modules\user\models\User;

/**
 * This is the model class for table "{{%shop_cart}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $type
 * @property integer $goods_id
 * @property integer $sku_id
 * @property integer $num
 * @property integer $created_at
 */
class GoodsCart extends ActiveRecord
{

    const TYPE_FOOD = 1;
    const TYPE_SEAT = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_cart}}';
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
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'type', 'goods_id', 'sku_id', 'num', 'created_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'type' => 'Type',
            'goods_id' => '商品id',
            'sku_id' => 'sku id',
            'num' => '数量',
            'created_at' => 'Created At',
        ];
    }

    public static function create($user_id, $sku_id, $goods_model, array $extra=[], $type=self::TYPE_FOOD)
    {

        $model = self::find()->where(['user_id'=>$user_id, 'goods_id'=>$goods_model->id, 'sku_id'=>$sku_id])->one();

        if (!$model) {
            $model = new self;
            $model->user_id = $user_id;
            $model->type = $type;
            $model->goods_id = $goods_model->id;
            $model->sku_id = $sku_id;
        }


        $model->num = isset($extra['num']) ? $extra['num'] : 1;
        $model->note = isset($extra['note']) ? $extra['note'] : '';

        return $model->save();
    }

    /**
     * @name 删除 
     */
    public static function drop($user_id, $goods_id)
    {

        $filter = ['user_id'=>$user_id, 'goods_id'=>$goods_id];
        
        return Yii::$app->db->createCommand()
                ->delete(self::tableName(), $filter)
                ->execute();
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getGoods()
    {
        return $this->hasOne(Goods::className(), ['id' => 'goods_id']);
    }

    public function getSku()
    {
        return $this->hasOne(Sku::className(), ['id' => 'sku_id']);
    }
}
