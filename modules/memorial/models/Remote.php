<?php

namespace app\modules\memorial\models;

use app\modules\order\models\OrderRel;
use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%memorial_remote}}".
 *
 * @property integer $id
 * @property integer $memorial_id
 * @property integer $tomb_id
 * @property integer $user_id
 * @property integer $sku_id
 * @property integer $order_rel_id
 * @property string $start
 * @property string $end
 * @property string $video
 * @property integer $thumb
 * @property string $note
 * @property string $price
 * @property integer $status
 * @property integer $created_at
 */
class Remote extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%memorial_remote}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['memorial_id', 'tomb_id', 'user_id', 'sku_id', 'order_rel_id', 'start', 'end', 'price'], 'required'],
            [['memorial_id', 'tomb_id', 'user_id', 'sku_id', 'order_rel_id', 'thumb', 'status', 'created_at'], 'integer'],
            [['start', 'end'], 'safe'],
            [['note'], 'string'],
            [['price'], 'number'],
            [['video'], 'string', 'max' => 255],
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
            'memorial_id' => '纪念馆',
            'tomb_id' => '墓位',
            'user_id' => '用户',
            'sku_id' => 'Sku ID',
            'order_rel_id' => '订单id',
            'start' => '开始日期',
            'end' => '结束日期',
            'video' => '视频地址',
            'thumb' => '缩略图',
            'note' => '备注',
            'price' => '价格',
            'status' => '状态',
            'created_at' => '添加时间',
        ];
    }

    public static function create($order_rel_id)
    {
        $rel = OrderRel::findOne($order_rel_id);
        $goods = $rel->goods;
        Yii::error($rel);
        Yii::error($goods);

        $memorial = Memorial::find()->where(['tomb_id'=>$rel->tid])->one();

        $data = [
            'memorial_id' => $memorial->id,
            'tomb_id' => $rel->tid,
            'user_id' => $rel->user_id,
            'sku_id' => $rel->sku_id,
            'order_rel_id' => $order_rel_id,
            'start' => date('Y-m-d', strtotime($rel->use_time)),
            'end' => date('Y-m-d', strtotime('+'.$goods->days . ' days', strtotime($rel->use_time))),
            'note' => $rel->note,
            'price' => $rel->price,
        ];

        Yii::error($data);

        $model = new self();
        $model->load($data, '');

        if ($model->save() !== false) {
            return $model;
        }

        Yii::error($model->getErrors());

        return false;
    }
}