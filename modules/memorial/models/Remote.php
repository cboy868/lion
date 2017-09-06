<?php

namespace app\modules\memorial\models;

use app\modules\grave\models\Tomb;
use app\modules\order\models\OrderRel;
use app\modules\shop\models\Goods;
use app\modules\shop\models\Sku;
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
    const PRIVACY_PUBLIC = 0;
    const PRIVACY_FRIENDS = 1;
    const PRIVACY_PRIVATE = 2;

    const STATUS_PAY = 1;//支付完成
    const STATUS_OK = 2;//视频上传完成

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%memorial_remote}}';
    }

    public static function status($status = null)
    {
        $s = [
            self::STATUS_DEL => '删除',
            self::STATUS_NORMAL => '支付完成，待上传照片',
            self::STATUS_OK => '祭祀完成'

        ];

        if ($status === null) {
            return $s;
        }

        return $s[$status];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['memorial_id', 'tomb_id', 'user_id', 'sku_id', 'order_rel_id', 'start', 'end', 'price'], 'required'],
            [['memorial_id', 'tomb_id', 'user_id', 'sku_id', 'order_rel_id', 'thumb', 'status', 'created_at','privacy'], 'integer'],
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
            'privacy' => $memorial->privacy
        ];


        $model = new self();
        $model->load($data, '');

        if ($model->save() !== false) {
            return $model;
        }

        Yii::error($model->getErrors(),__METHOD__);

        return false;
    }

    public function getTomb()
    {
        return $this->hasOne(Tomb::className(),['id' => 'tomb_id']);
    }

    public function getSku()
    {
        return $this->hasOne(Sku::className(), ['id' => 'sku_id']);
    }

    public function getMemorial()
    {
        return $this->hasOne(Memorial::className(), ['id' => 'memorial_id']);
    }

    public function getOrderRel()
    {
        return $this->hasOne(OrderRel::className(), ['id'=>'order_rel_id']);
    }

    public function getUser()
    {
        return $this->hasOne(\app\modules\user\models\User::className(), ['id'=>'user_id']);
    }

    public function getGoods()
    {
        $rel = $this->orderRel;

        return Goods::findOne($rel->goods_id);
    }

    public function getGoodsSkuName()
    {
        return $this->goods->name == $this->sku->name ? $this->goods->name : $this->goods->name . $this->sku->name;
    }

    public function saveAttach($info)
    {
        $this->thumb = $info['mid'];
        return $this->save();
    }
}