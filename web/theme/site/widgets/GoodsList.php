<?php

namespace app\web\theme\site\widgets;

use yii;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\base\Widget;


use app\modules\shop\models\search\Goods as GoodsSearch;
use app\modules\shop\models\AvRel;
/**
 * Webuploader Widget
 * <?php echo Webup::widget(['options'=>['formData'=>['res_name'=>'article', 'db'=>true]]]);?>
 */
class GoodsList extends Widget {


    public $options;

    /**
     * Renders the widget.
     */
    public function run() {
        return $this->data();
    }


    public function data()
    {

        $params = Yii::$app->request->queryParams;

        $searchModel = new GoodsSearch();

        if (isset($params['avid'])) {
            $goods_ids = AvRel::getGoodsIdByAvId($params['avid']);
            $params["Goods"]['id'] = $goods_ids;
        }

        if (isset($params['category_id'])) {
            $params["Goods"]['category_id'] = $params['category_id'];
        }

        $params['psize'] = isset($params['psize']) ? $params['psize'] : 12;

        $dataProvider = $searchModel->homeSearch($params);

        $models = $dataProvider->getModels();
        $page = $dataProvider->getPagination();

        $attrs = AvRel::attrs();

        $params['mode'] = isset($params['mode']) ? $params['mode'] : 'list';


        return $this->render('goods' . $params['mode'], [
            'models' => $models,
            'page' => $page,
            'current_cate' => Yii::$app->getRequest()->get('category_id'),
            'attrs' => $attrs,
            'get' => $params
        ]);

    }

}
