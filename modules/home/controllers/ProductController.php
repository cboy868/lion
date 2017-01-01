<?php

namespace app\modules\home\controllers;

use Yii;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\modules\shop\models\Category;
use app\modules\shop\models\Goods;
use app\modules\shop\models\search\Goods as GoodsSearch;

class ProductController extends \app\core\web\HomeController
{
   
   public $layout = 'home.php';
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {


        $searchModel = new GoodsSearch();

        $params = Yii::$app->request->queryParams;

        if ($params['category_id']) {
            $params["Goods"]['category_id'] = $params['category_id'];
        }

        $dataProvider = $searchModel->search($params);

        $models = $dataProvider->getModels();
        $page = $dataProvider->getPagination();

        $cates = $this->getCates();


        return $this->render('index', [
            'models' => $models,
            'page' => $page,
            'searchModel' => $searchModel,
            // 'dataProvider' => $dataProvider,
            'cates'       => $cates,
            'current_cate' => Yii::$app->getRequest()->get('category_id')
        ]);




     //    $cates = Category::find()->asArray()->all();


    	// return $this->render('index', ['cates'=>$cates]);
    }

    public function actionView($id)
    {
        return $this->render('view');
    }


    private function getCates()
    {
        $tree = Category::sortTree();

        foreach ($tree as $k => &$v) {
            $v['url'] = Url::toRoute(['index', 'Goods[category_id]'=>$v['id']]);
        }

        $tree = \yii\helpers\ArrayHelper::index($tree, 'id');
        $tree = \app\core\helpers\Tree::recursion($tree,0,1);

        return $tree;
    }

}
