<?php

namespace app\modules\task\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\modules\user\models\User as SysUser;


use app\modules\order\models\OrderRel;
use app\modules\order\models\Order;

use app\modules\shop\models\Goods as ShopGoods;
use app\modules\grave\models\Tomb;

/**
 * This is the model class for table "{{%task}}".
 *
 * @property integer $id
 * @property integer $cate_id
 * @property string $res_name
 * @property integer $res_id
 * @property integer $user_id
 * @property integer $order_rel_id
 * @property integer $op_id
 * @property string $title
 * @property string $content
 * @property string $pre_finish
 * @property string $finish
 * @property integer $status
 * @property integer $created_at
 */
class Task extends \app\core\db\ActiveRecord
{

    const STATUS_FINISH = 2;//完成
//    const STATUS_OVERDUE = 5;//过期
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%task}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cate_id', 'res_id', 'user_id', 'order_rel_id', 'op_id', 'status', 'created_at', 'is_msg'], 'integer'],
            [['content'], 'string'],
            [['pre_finish', 'finish'], 'safe'],
            [['cate_id', 'title'], 'required'],
            [['res_name', 'title'], 'string', 'max' => 200],
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

    public static function status($status = null)
    {
        $s = [
            self::STATUS_DEL => '删除',
            self::STATUS_NORMAL => '未完成',
            self::STATUS_FINISH => '完成'
        ];

        if ($status === null) {
            return $s;
        }

        return $s[$status];
    }

    public function getStatusText()
    {

        if ($this->pre_finish < date('Y-m-d')) {
            return '已过期';
        }

        return static::status($this->status);
    }



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cate_id' => '任务分类',
            'res_name' => '任务类型',
            'res_id' => '关联id',
            'user_id' => '发起人',
            'order_rel_id' => '关联定单',
            'op_id' => '操作人',
            'title' => '任务标题',
            'content' => '任务内容',
            'pre_finish' => '预定完成时间',
            'finish' => '实际完成时间',
            'status' => '状态',
            'statusText' => '状态',
            'created_at' => '添加时间',
            'op.username'=>'任务接收人',
//            'msg_time' => '提醒时间',
            'is_msg' => '已发消息'
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $this->op_id = $this->op_id ? $this->op_id : $this->info->default->user_id;
        $this->user_id = $this->user_id ? $this->user_id : Yii::$app->user->id;
        $this->res_name = empty($this->res_name) ? 'common' : $this->res_name;
        $this->res_id = $this->res_id ? $this->res_id : 0;
        return true;
    }

    public static function create($order_id, $res_name="common", $res_id=0)
    {
        self::createGoodsTask($order_id, $res_name, $res_id);
        self::createCategoryTask($order_id, $res_name, $res_id);
        self::createSpecialTask($order_id, $res_name, $res_id);
    }

    /**
     * @name 特殊商品任务
     */
    public static function createSpecialTask($order_id, $res_name="common", $res_id=0)
    {
        $order = Order::findOne($order_id);

        $rels = $order->rels;


        foreach ($rels as $k => $v) {
            if ($v->type != \app\modules\order\models\OrderRel::TYPE_SPECIAL_GOODS) {
                continue;
            }

            $tinfo = Info::findOne($v->category_id);


            $tinfo->createTask($v, $res_name, $res_id);

        }

    }

    /**
     * @name 按商品添加任务
     */
    public static function createGoodsTask($order_id, $res_name="common", $res_id=0)
    {
        $order = Order::findOne($order_id);
        $rels = $order->rels;

        $goods_ids = [];
        foreach ($rels as $k => $v) {
            if ($v->type == \app\modules\grave\models\OrderRel::TYPE_TOMB) {
                continue ;
            }

            if ($v->type == \app\modules\order\models\OrderRel::TYPE_SPECIAL_GOODS) {
                continue;
            }

            $goods_ids['res_id'][$v->id] = $v->goods_id;
            $goods_ids['model'][$v->id] = $v;
        }

        if (count($goods_ids) < 1) {
            return;
        }

        $goods_rels = Goods::find()->where(['res_name'=>'goods', 'res_id'=>$goods_ids['res_id']])
            ->indexBy('res_id')->all();

        if ($goods_rels) {
            foreach ($goods_ids['model'] as $k => $rel) {

                if (!isset($goods_rels[$rel->goods_id])) {
                    continue;
                }

                $goods = $goods_rels[$rel->goods_id];
                $info = $goods->info;

                $info->createTask($rel, $res_name, $res_id);
            }
        }
    }

    /**
     * @name 按分类添加任务
     */
    public static function createCategoryTask($order_id, $res_name="common", $res_id=0)
    {
        $order = Order::findOne($order_id);
        $rels = $order->rels;
        $category_ids = [];
        foreach ($rels as $k => $v) {
            if ($v->type == \app\modules\grave\models\OrderRel::TYPE_TOMB) {
                continue ;
            }

            if ($v->type == \app\modules\order\models\OrderRel::TYPE_SPECIAL_GOODS) {
                continue;
            }
            $category_ids['res_id'][$v->id] = $v->category_id;
            $category_ids['model'][$v->id] = $v;
        }

        if (count($category_ids) <= 0) {
            return ;
        }

        $cate_rels = Goods::find()->where(['res_name'=>'category', 'res_id'=>$category_ids['res_id']])
                                ->indexBy('res_id')->all();

        if ($cate_rels) {
            foreach ($category_ids['model'] as $k => $rel) {

                if (!isset($cate_rels[$rel->category_id])) {
                    continue;
                }
                $cate = $cate_rels[$rel->category_id];

                $info = $cate->info;
                $info->createTask($rel, $res_name, $res_id);

            }
        }
    }

    public static function replace($rel, $content, $res_name='common', $res_id=0)
    {

        $replace = [
            'search' => [
                '{pre_finish}','{rel_note}', '{order_id}' , '{goods}'
            ],
            'replace' => [
                $rel->use_time, $rel->note, $rel->order_id, $rel->title
            ]
        ];

        if ($res_name == 'tomb') {
            $tomb = Tomb::findOne($res_id);
            $replace['search'][] = '{tomb_no}';
            $replace['replace'][] = $tomb->tomb_no;
        }

        return str_replace($replace['search'], $replace['replace'], $content);
    }


    public function finish()
    {
        $this->status = self::STATUS_FINISH;
        $this->finish = date('Y-m-d H:i:s');
        return $this->save();
    }

    public function getUser()
    {
        return $this->hasOne(SysUser::className(),['id'=>'user_id']);
    }
    public function getOp()
    {
        return $this->hasOne(SysUser::className(),['id'=>'op_id']);
    }
    public function getInfo()
    {
        return $this->hasOne(Info::className(),['id'=>'cate_id']);
    }

    public function getTomb()
    {
        if ($this->res_name == 'tomb') {
            return $this->hasOne(Tomb::className(),['id'=>'res_id']);
        }
        return null;
    }

}
