<?php

namespace app\modules\grave\controllers\admin;

use app\core\helpers\Tree;
use app\modules\grave\models\Customer;
use app\modules\grave\models\Grave;
use app\modules\shop\models\Bag;
use app\modules\user\models\User;
use Yii;
use app\modules\grave\models\Tomb;
use app\modules\shop\models\Goods;
use app\modules\shop\models\Category;
use app\modules\shop\models\Sku;

use app\modules\grave\models\InsProcess;
use app\core\web\BackController;
use app\modules\grave\models\Portrait;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

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

        $query = Goods::find()->andWhere(['status'=>Goods::STATUS_NORMAL])
            ->andWhere(['is_show'=>1]);

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

        $config = Yii::$app->getModule('grave')->params['goods']['cate'];

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
        $taskCate = \app\modules\task\models\Info::find()->where(['is_leaf'=>0])->all();


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

    // 以下是商品部的一些东西

    /**
     * @name 商品部展示
     */
    public function actionShop($tomb_id=null)
    {
        $data = [];
        if ($tomb_id) {
            $tomb = Tomb::findOne($tomb_id);

            if (!$tomb) {
                throw new NotFoundHttpException('墓位不存在');
            }

            $grave = Grave::findOne($tomb->grave_id);


            $customer = Customer::findOne($tomb->customer_id);
            $data['tomb'] = $tomb;
            $data['grave'] = $grave;
            $data['customer'] = $customer;
        }

        $graves = Grave::find()->where(['<>','status',Grave::STATUS_DELETE])
                                ->andWhere(['is_leaf'=>1])
                                ->all();
        $graves = ArrayHelper::map($graves, 'id', 'name');
        $data['graves'] = $graves;

        $show_cates = Category::find()->where(['is_leaf'=>1,'status'=>Category::STATUS_NORMAL,'is_show'=>1])->all();
        $show_cate_ids = ArrayHelper::getColumn($show_cates, 'id');
        $show_goods = Goods::find()->where(['category_id'=>$show_cate_ids,'status'=>Goods::STATUS_NORMAL])
                                    ->andWhere(['is_show'=>1])
                                    ->all();

        $staffs = User::staffs();
        $staffs = ArrayHelper::map($staffs, 'id', 'username');

        $goods = ArrayHelper::index($show_goods, 'id', 'category_id');



        $cates = Category::find()->andWhere(['status'=>Category::STATUS_NORMAL,'is_show'=>1])
            ->orderBy('level desc, sort desc')
            ->indexBy('id')
            ->all();

        $cates_tree = Tree::treeShow($cates, ['\app\core\helpers\Tree', 'createGoodsCateLink']);

        //礼包
        $bags = Bag::find()->where(['status'=>Bag::STATUS_NORMAL])->all();

        $data['goods'] = $goods;
        $data['bags'] = $bags;
        $data['staffs'] = $staffs;
        $data['cates_tree'] = $cates_tree;

        return $this->render('shop',$data);
    }

    /**
     * @name 商品部下单
     */
    public function actionOrder()
    {
        $post = Yii::$app->request->post();


        $tomb_id = $post['tomb_id'];
        $tomb = Tomb::findOne($tomb_id);

        $op_id = $post['op_id'];
//        $is_shop = $post['is_shop'];
//        $customer_name = $post['customer_name'];
//        $mobile = $post['mobile'];
        $use_time = $post['use_time'];
        $des = $post['des'];
        $goods_info = (array) json_decode($post['goods_info']);
        $bag_info = (array) json_decode($post['bag_info']);

        if (!$goods_info && !$bag_info) {
            return $this->redirect(['shop', 'tomb_id'=>$tomb_id]);
        }


        foreach($goods_info as &$info ) {
            $info = (array) $info;
        }unset($info);

        foreach($bag_info as &$info ) {
            $info = (array) $info;
        }unset($info);

        $config = Yii::$app->getModule('grave')->params['goods']['cate'];

        $ins_cate = $config['ins'];
        $portrait_cate = $config['portrait'];

        foreach($goods_info as $sku_id=>$info) {

            if ($info['num'] <= 0) {
                continue;
            }

            $extra = array(
                'num' => $info['num'],
                'tid' => $tomb_id,
                'op_id' => $op_id,
                'use_time' => $use_time,
                'order_note' => $des,
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

        foreach($bag_info as $bag_id=>$info) {

            if ($info['num'] <= 0) {
                continue;
            }

            $extra = array(
                'num' => $info['num'],
                'tid' => $tomb_id,
                'op_id' => $op_id,
                'use_time' => $use_time,
                'order_note' => $des,
            );
            $bag = Bag::findOne($bag_id);
            $order_info = $bag->order($tomb->user_id, $extra);
        }

        return $this->redirect(['/order/admin/default/view', 'id'=>$order_info['order']->id]);
    }


}
