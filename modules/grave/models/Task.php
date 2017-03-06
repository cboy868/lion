<?php

namespace app\modules\grave\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\modules\order\models\OrderRel;
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

    /**
     * @name 添加任务
     */
    public static function create($tomb_id, $info_id, $order_rel_id)
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
