<?php

namespace app\modules\grave\controllers\admin;

use Yii;
use app\modules\grave\models\Tomb;
use app\modules\shop\models\Goods;
use app\modules\shop\models\Category;
use app\modules\shop\models\Sku;

use app\modules\grave\models\InsProcess;
use app\core\web\BackController;
use app\modules\grave\models\Portrait;
use yii\data\Pagination;
/**
 * GoodsController implements the CRUD actions for Goods model.
 */
class MallController extends BackController
{

    /**
     * @return array|string
     * @name 小商城
     */
    public function actionIndex()
    {
        $req = Yii::$app->request;
        $flag = true;
        if ($req->isPost) {
            return $this->order();
        }

        $tomb_id = $req->get('tomb_id');
        if ($tomb_id) {
            $model = Tomb::findOne($tomb_id);
        }

        $tree = [];
        $tname = '商品';
        $category_id = $req->get('category_id');
        if ($category_id) {
            $first = Category::findOne($category_id);

            if (!$first) {
                return '无此分类';
            } 
            $tname = $first->name;
        } else {
            $tree = Category::sortTree(['status'=>Category::STATUS_NORMAL], 'sort asc');

            $first_cate = 0;
            foreach ($tree as &$v) {
                $v['thumb'] = Category::getThumb($v['thumb'], '36x36');
                if ($v['is_leaf'] == 1 && $first_cate == 0) {
                    $first_cate = $v['id'];
                    break;
                }
            }unset($v);

            $first = Category::findOne($first_cate);
        }
        if ($req->isAjax) {
            return $this->renderAjax('index', [
                'goods_cates' => $tree,
                // 'goods_list' => $first->goods,
                'tomb' => isset($model) ? $model : '',
                'first' => $first,
                'tname' => $tname,
                'get' => $req->get()
            ]);
        }
        return $this->render('index', [
                'goods_cates' => $tree,
                'tomb' => isset($model) ? $model : '',
                // 'goods_list' => $first->goods,
                'tname' => $tname,
                'first' => $first,
                'get' => $req->get()
            ]);
    }


    /**
     * @param int $category_id
     * @param string $name
     * @return string
     * @name 商品列表
     */
    public function actionGoods($category_id=0, $name='')
    {

        $query = Goods::find()->andWhere(['status'=>Goods::STATUS_NORMAL]);

        if ($category_id) {
            $query->andWhere(['category_id'=>$category_id]);
        }

        if ($name) {
            $query->andWhere(['like', 'name', $name]);
        }

        $count = $query->count();

        $pagination = new Pagination(['totalCount' => $count, 'pageSize'=>15]);

        $models = $query->offset($pagination->offset)
                        ->limit($pagination->limit)
                        ->all();

        return $this->renderAjax('goods', ['models'=>$models, 'pagination'=>$pagination]);
    }


    /**
     * @return array
     * @name 下订单
     */
    public function order()
    {
        $post = Yii::$app->request->post();

        $goods_info = (array) json_decode($post['goods_info']);

        $tomb_id = $post['tomb_id'];
        $tomb = Tomb::findOne($tomb_id);

        foreach($goods_info as &$info ) {
            $info = (array) $info;
        }unset($info);

        $config = Yii::$app->params['goods']['cate'];

        $ins_cate = $config['ins'];
        $portrait_cate = $config['portrait'];

        foreach($goods_info as $sku_id=>$info) {

            if ($info['num'] <= 0) {
                continue;
            }

            $extra = array(
                'num' => $info['num'],
                'tid' => $tomb_id
            );
            $sku = Sku::findOne($sku_id);
            $order_info = $sku->order($tomb->user_id, $extra);
            $rel = $order_info['rel'];
            $goods = Goods::findOne($info['id']);

            if ($ins_cate == $goods->category_id) {
                InsProcess::insGoods($tomb_id, $sku, $rel);
            }

            if ($portrait_cate == $goods->category_id) {
                Portrait::PortraitGoods($tomb_id, $sku, $rel);
            }
        }

        return $this->json(null, null, 1);
    }

    /**
     * @name 特殊商品
     */
    public function actionSpecialGoods($tomb_id)
    {
        $tomb = Tomb::findOne($tomb_id);
        $taskCate = \app\modules\task\models\Info::find()->all();


        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();

            $goods = new Goods;
            $goods->id=0;
            $goods->category_id = $post['sp']['task'];
            $goods->price = $post['sp']['price'];
            $goods->name = $post['sp']['name'];


            $extra = [
                'use_time' => $post['sp']['use_time'],
                'note'     => $post['sp']['note'],
                'tid'      => $tomb->id,
                'type'     => \app\modules\order\models\OrderRel::TYPE_SPECIAL_GOODS
            ];
            $orderinfo = $goods->order($tomb->user_id, $extra);

            if ($orderinfo['order']) {
                return $this->redirect(['/order/admin/default/view', 'id'=>$orderinfo['order']->id]);
            }

        }
        return $this->render('special-goods', ['tomb'=>$tomb, 'task'=>$taskCate]);
    }


}
