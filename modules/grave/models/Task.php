<?php

namespace app\modules\grave\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\modules\order\models\OrderRel;
use app\modules\order\models\Order;

use app\modules\task\models\Goods;
use app\modules\shop\models\Goods as ShopGoods;


/**
 * This is the model class for table "{{%grave_bury}}".
 *
 * @property integer $id
 * @property integer $tomb_id
 * @property integer $user_id
 * @property integer $dead_id
 * @property integer $dead_name
 * @property integer $dead_num
 * @property integer $bury_type
 * @property string $pre_bury_date
 * @property string $bury_date
 * @property string $bury_time
 * @property integer $bury_user
 * @property integer $bury_order
 * @property string $note
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 */
class Task extends \app\modules\task\models\Task
{


    public static function create($tomb_id, $order_id)
    {

        $order = Order::findOne($order_id);
        $rels = $order->rels;


        $goods_ids = [];
        $category_ids = [];

        foreach ($rels as $k => $v) {

            $category_ids['res_id'][$v->id] = $v->category_id;
            $category_ids['model'][$v->id] = $v;

            $goods_ids['res_id'][$v->id] = $v->goods_id;
            $goods_ids['model'][$v->id] = $v;

        }

        $cate_rels = Goods::find()->where(['res_name'=>'category', 'res_id'=>$category_ids['res_id']])->indexBy('res_id')->all();
        $goods_rels = Goods::find()->where(['res_name'=>'goods', 'res_id'=>$goods_ids['res_id']])->indexBy('res_id')->all();



        $tomb = Tomb::findOne($tomb_id);

        if ($cate_rels) {
            foreach ($category_ids['model'] as $k => $rel) {

                if (!isset($cate_rels[$rel->category_id])) {
                    continue;
                }
                $cate = $cate_rels[$rel->category_id];
                $content = $cate->info->msg;

                $replace = [
                    'search' => [
                        '{tomb_no}', '{pre_finish}','{rel_note}', '{order_id}' , '{goods}'
                    ],
                    'replace' => [
                        $tomb->tomb_no, $rel->use_time, $rel->note, $rel->order_id, $rel->goods->name
                    ]

                ];

                $content = str_replace($replace['search'], $replace['replace'], $content);
                $data = [
                    'res_name' => 'tomb',
                    'res_id' => $tomb_id,
                    'user_id' => 0,
                    'cate_id' => $cate->info->id,
                    'title'  => $cate->info->name,
                    'op_id'  => $cate->info->default->user_id,
                    'content' => $content,
                    'pre_finish' => $rel->use_time,
                    'order_rel_id' => $rel->id

                ];
                $model = new self;

                $model->load($data, '');
                $model->save();

            }
        }

        if ($goods_rels) {
            foreach ($goods_ids['model'] as $k => $rel) {


                if (!isset($goods_rels[$rel->goods_id])) {
                    continue;
                }

                $goods = $goods_rels[$rel->goods_id];

                $content = $goods->info->msg;

                $replace = [
                    'search' => [
                        '{tomb_no}', '{pre_finish}','{rel_note}', '{order_id}' , '{goods}'
                    ],
                    'replace' => [
                        $tomb->tomb_no, $rel->use_time, $rel->note, $rel->order_id, $rel->goods->name
                    ]

                ];

                $content = str_replace($replace['search'], $replace['replace'], $content);
                $data = [
                    'res_name' => 'tomb',
                    'res_id' => $tomb_id,
                    'user_id' => 0,
                    'cate_id' => $goods->info->id,
                    'title'  => $goods->info->name,
                    'op_id'  => $goods->info->default->user_id,
                    'content' => $content,
                    'pre_finish' => $rel->use_time,
                    'order_rel_id' => $rel->id

                ];
                $model = new self;
                $model->load($data, '');
                $model->save();
            }
        }

        return true;



    }

    /**
     * @name 添加任务
     */
    public static function create1($tomb_id, $info_id, $order_rel_id)
    {
        $tomb = Tomb::findOne($tomb_id);
        $orderRel = OrderRel::findOne($order_rel_id);
        $goods_model = ShopGoods::findOne($orderRel->goods_id);
        $info_goods_rel = Goods::find()->where(['info_id'=>$info_id, 'res_name'=>Goods::RES_GOODS, 'res_id'=>$orderRel->goods_id])->one();
        $info_category_rel = Goods::find()->where(['info_id'=>$info_id, 'res_name'=>Goods::RES_CATEGORY, 'res_id'=>$goods_model->category->id])->one();


        if (!($info_goods_rel || $info_category_rel)) {
            return ;
        }

        $content = isset($info_category_rel->msg) ? $info_category_rel->msg : $info_goods_rel->msg;//   $info_goods_rel->msg || $info_category_rel->msg;

        $replace = [
            'search' => [
                '{tomb_no}', '{pre_finish}','{rel_note}', '{order_id}'
            ],
            'replace' => [
                $tomb->tomb_no, $orderRel->use_time, $orderRel->note, $orderRel->order_id
            ]

        ];

        $content = str_replace($replace['search'], $replace['replace'], $content);

        $model = new self;

        $model->res_name = 'tomb';
        $model->res_id = $tomb_id;
        $model->user_id = 0;
        $model->cate_id = $info_id;
        $model->title = $model->info->name;
        $model->op_id = $model->info->default->user_id;
        $model->content = $content;
        $model->pre_finish = $orderRel->use_time;
        $model->order_rel_id = $order_rel_id;

        return $model->save();

    }
}
