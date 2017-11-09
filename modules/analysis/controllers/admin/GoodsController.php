<?php

namespace app\modules\analysis\controllers\admin;

use yii;
use app\modules\analysis\models\SettlementRel;
use app\modules\shop\models\Category;
use app\modules\shop\models\Goods;

/**
 * Class GoodsController
 * @package app\modules\analysis\controllers\admin
 */
class GoodsController extends \app\core\web\BackController
{
    static $cache_term = 3600;

    public function actionIndex()
    {
        return $this->render('index');
    }


    public function actionSale()
    {
        $date = explode('-', date('Y-m-d'));

        $cache = Yii::$app->cache;
        $info = $cache->get('goods_sale');

         if ($info === false) {

             $info = SettlementRel::find()->where(['year'=>$date[0], 'status'=>1])
                 ->andWhere(['res_name'=>'goods'])
                 ->select(['month', 'sum(price) as total'])
                 ->indexBy('month')
                 ->groupBy('month')
                 ->asArray()
                 ->all();
             $cache->set('goods_sale', $info, self::$cache_term);
         }

        ksort($info);

        return $this->json($info, null, 1);
    }

    /**
     * 本月前n个热销商品
     */
    public function actionHotPrice($num=10, $month=null)
    {

        $month = $month == null ? date('m') : $month;

        $cache = Yii::$app->cache;
        $result = $cache->get('goods_hot_price');

        if ($result === false) {

            $info = SettlementRel::find()->where(['year'=>date('Y'), 'status'=>1])
//            ->andWhere(['month'=>$month])
                ->andWhere(['res_name'=>'goods'])
                ->select(['goods_id', 'sum(price) as total'])
                ->indexBy('goods_id')
                ->groupBy('goods_id')
                ->orderBy('total desc')
                ->limit($num)
                ->asArray()
                ->all();


            $goods_ids = array_keys($info);
            $ginfo = Goods::find()->where(['id'=>$goods_ids])
                ->select(['name', 'id'])
                ->indexBy('id')
                ->asArray()
                ->all();

            $result = [];
            foreach ($info as $k => $v) {
                $v['name'] = $ginfo[$k]['name'];
                $result[] = $v;
            }

            $cache->set('goods_hot_price', $result, self::$cache_term);
        }

        return $this->json($result);

    }

    /**
     * 本月前n个热销商品
     */
    public function actionHotNum($num=10, $month=null)
    {

        $month = $month == null ? date('m') : $month;

        $cache = Yii::$app->cache;
        $result = $cache->get('goods_hot_num');

        if ($result === false) {
            $num_info = SettlementRel::find()->where(['year'=>date('Y'), 'status'=>1])
//            ->andWhere(['month'=>$month])
                ->andWhere(['res_name'=>'goods'])
                ->select(['goods_id', 'sum(num) as num'])
                ->indexBy('goods_id')
                ->groupBy('goods_id')
                ->orderBy('num desc')
                ->limit($num)
                ->asArray()
                ->all();

            $goods_ids = array_keys($num_info);
            $ginfo = Goods::find()->where(['id'=>$goods_ids])
                ->select(['name', 'id'])
                ->indexBy('id')
                ->asArray()
                ->all();


            $result = [];
            foreach ($num_info as $k => $v) {
                $v['name'] = $ginfo[$k]['name'];
                $result[] = $v;
            }

            $cache->set('goods_hot_num', $result, self::$cache_term);

        }


        return $this->json($result);
    }

    /**
     * @name 各分类商品月销售统计
     */
    public function actionCate()
    {
        $cache = Yii::$app->cache;
        $result = $cache->get('goods_cate');

        if ($result === false) {
            $info = SettlementRel::find()->where(['year'=>date('Y'), 'status'=>1])
//            ->andWhere(['month'=>$month])
                ->andWhere(['<>', 'category_id', 0])
                ->andWhere(['res_name'=>'goods'])
                ->select(['category_id', 'sum(price) as total'])
                ->indexBy('category_id')
                ->groupBy('category_id')
                ->orderBy('total desc')
                ->asArray()
                ->all();

            $cids = array_keys($info);
            $cinfo = Category::find()->where(['id'=>$cids])
                ->select(['id', 'name'])
                ->indexBy('id')
                ->asArray()
                ->all();

            $result = [];
            foreach ($info as $k=>$v) {
                $v['cname'] = $cinfo[$k]['name'];
                $result[] = $v;
            }
            $cache->set('goods_cate', $result, self::$cache_term);
            Yii::error($result);
        }

        return $this->json($result);

    }

}
