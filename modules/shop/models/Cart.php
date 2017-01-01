<?php

namespace app\modules\shop\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%shop_cart}}".
 *
 * @property integer $id
 * @property string $wechat_uid
 * @property integer $type
 * @property integer $goods_id
 * @property integer $num
 * @property string $note
 * @property integer $created_at
 */
class Cart extends \app\core\db\ActiveRecord
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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['wechat_uid'], 'required'],
            [['type', 'goods_id', 'num', 'created_at', 'wechat_uid'], 'integer'],
            [['note'], 'string'],
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
            'wechat_uid' => 'Wechat_uid',
            'type' => 'Type',
            'goods_id' => 'Goods ID',
            'num' => 'Num',
            'note' => 'Note',
            'created_at' => 'Created At',
        ];
    }

    public static function create($sku_id, $goods_model, array $extra=[], $type=self::TYPE_FOOD)
    {
        $session = Yii::$app->getSession();
        $wechat_uid = $session['wechat_user']['wechat_uid'];

        $model = self::find()->where(['wechat_uid'=>$wechat_uid, 'goods_id'=>$goods_model->id, 'sku_id'=>$sku_id])->one();

        if (!$model) {
            $model = new self;
            $model->wechat_uid = $wechat_uid;
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
    public static function drop($wechat_uid, $goods_id)
    {

        $filter = ['wechat_uid'=>$wechat_uid, 'goods_id'=>$goods_id];
        
        return Yii::$app->db->createCommand()
                ->delete(self::tableName(), $filter)
                ->execute();
    }
}
