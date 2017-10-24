<?php

namespace app\modules\grave\models;

use app\modules\task\models\Task;
use Yii;
use app\modules\shop\models\Goods;
use app\modules\grave\models\Tomb;
use yii\behaviors\TimestampBehavior;
use app\modules\shop\models\Sku;
use app\modules\user\models\User;
use app\core\models\Attachment;
/**
 * This is the model class for table "{{%grave_portrait}}".
 *
 * @property integer $id
 * @property integer $guide_id
 * @property integer $user_id
 * @property integer $tomb_id
 * @property string $title
 * @property integer sku_id
 * @property integer $order_id
 * @property integer $order_rel_id
 * @property string $dead_ids
 * @property string $photo_original
 * @property string $photo_processed
 * @property integer $confirm_by
 * @property string $confirm_at
 * @property string $photo_confirm
 * @property string $use_at
 * @property string $up_at
 * @property integer $notice_id
 * @property integer $type
 * @property string $note
 * @property integer $status
 * @property integer $updated_at
 * @property integer $created_at
 */
class Portrait extends \app\core\db\ActiveRecord
{


    const STATUS_INIT = 1; //待上传
    const STATUS_PS = 3;  //待ps
    const STATUS_CONFIRM = 4; //待确认
    const STATUS_MAKE = 5; //待制作
    const STATUS_COMPLETE = 6; //完成




    public static function status($status =null)
    {
        $st = [
            self::STATUS_INIT => '待上传',
            self::STATUS_PS   => '待PS',
            self::STATUS_CONFIRM => '待确认',
            self::STATUS_MAKE    => '待制作',
            self::STATUS_COMPLETE   => '完成'
        ];

        if ($status === null) {
            return $st;
        }

        return $st[$status];
    }


    public function getStatusText()
    {
        return self::status($this->status);
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%grave_portrait}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['guide_id', 'user_id', 'tomb_id'], 'required'],
            [['guide_id','photo_original', 'photo_processed','sort', 'user_id', 'tomb_id',
                'sku_id', 'order_id', 'order_rel_id', 'confirm_by', 'notice_id', 'type', 'status',
                'updated_at', 'created_at'], 'integer'],
            [['confirm_at', 'use_at', 'up_at', 'dead_ids'], 'safe'],
            [['note'], 'string'],
            [['title', 'photo_confirm'], 'string', 'max' => 200],
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
            'tomb_id' => '墓位',
            'title' => '标题',
            'sku_id' => 'Sku ID',
            'order_id' => '订单id',
            'order_rel_id' => 'Order Rel ID',
            'dead_ids' => '逝者id',
            'photo_original' => '原图',
            'photo_processed' => 'PS图',
            'confirm_by' => '确认人',
            'confirm_at' => '确认时间',
            'photo_confirm' => '确认图',
            'use_at' => '使用时间',
            'up_at' => '上传时间',
            'notice_id' => '',
            'type' => '类型',////瓷像、福寿牌、影雕
            'note' => '备注',
            'status' => '状态',
            'updated_at' => '更新时间',
            'created_at' => '添加时间',
            'statusText' => '瓷像状态'
        ];
    }


    public function getUser()
    {
        return $this->hasOne(User::className(),['id'=>'user_id']);
    }

    public function getConfirmUser()
    {
        return $this->hasOne(User::className(),['id'=>'confirm_by']);
    }

    public function getGuide()
    {
        return $this->hasOne(User::className(),['id'=>'guide_id']);
    }

    public function getTomb()
    {
        return $this->hasOne(Tomb::className(),['id'=>'tomb_id']);
    }

    public function getDeads()
    {
        $dead_ids = explode(',', $this->dead_ids);

        $deads = Dead::find()->where(['status'=>Dead::STATUS_NORMAL,'id'=>$dead_ids])->all();

        return $deads;
    }

    public function getSku()
    {
        return $this->hasOne(Sku::className(),['id'=>'sku_id']);
    }


    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }

    public static function PortraitGoods($tomb_id, $sku, $rel)
    {

        $tomb = Tomb::findOne($tomb_id);
        for ($i=0; $i < $rel->num; $i++) { 
            $portrait = self::find()->where(['tomb_id'=>$tomb_id])
                         ->andWhere(['sku_id'=>$sku->id])
                         ->andWhere(['<>', 'status', Dead::STATUS_DEL])
                         // ->andWhere(['status'=>Dead::STATUS_NORMAL])
                         ->andWhere(['sort'=>$i])
                         ->one();

            if (!$portrait) {
                $portrait = new self();
                $portrait->tomb_id = $tomb_id;
                $portrait->sort = $i;
            }

            $portrait->order_rel_id = $rel->id;
            $portrait->sku_id = $sku->id;
            $portrait->order_id = $rel->order_id;
            $portrait->user_id = $tomb->user_id;
            $portrait->guide_id = $tomb->guide_id;
            $portrait->title = $sku->name == $sku->goods->name ? $sku->name : $sku->goods->name . $sku->name;

            $portrait->save();

        }

        return true;
    }

    public function getOriginalImg($size='')
    {
        return Attachment::getById($this->photo_original, $size);
    }
    
    public function getProcessedImg($size='')
    {
        return Attachment::getById($this->photo_processed, $size);
    }

    public function getConfirmImg($size='')
    {
        return Attachment::getById($this->photo_confirm, $size);
    }

    public function getSkuInfo()
    {
        $sku = Sku::findOne($this->sku_id);
        return $sku;
    }

    public function saveAttach($info)
    {

        if ($info['use'] == 'ps') {
            $this->photo_processed = $info['mid'];
            $this->status = $this->status == self::STATUS_PS ? self::STATUS_CONFIRM : $this->status;
        } else if($info['use'] == 'original') {
            $this->photo_original = $info['mid'];
            $this->status = $this->status == self::STATUS_INIT ? self::STATUS_PS : $this->status;
        }
        return $this->save();
    }

    public function getOrder()
    {
        return $this->hasOne(\app\modules\order\models\Order::className(),['id'=>'order_id']);
    }

    public function confirm()
    {
        $this->confirm_by = Yii::$app->user->id;
        $this->confirm_at = date('Y-m-d H:i:s');
        $this->photo_confirm = $this->photo_processed;
        $this->status = self::STATUS_MAKE;

        if ($this->save()){

            Task::createConfirm($this->order_rel_id, 'portrait', $this->id);
            return true;
        } else {
            return false;
        }

    }
}
