<?php

namespace app\modules\order\controllers\member;


use yii;
use app\modules\shop\models\Gooods;
use app\modules\shop\models\Sku;
use app\modules\order\models\Order;
use app\modules\order\models\Pay;
use app\core\libs\Fpdf;
use app\modules\order\models\OrderSearch;
use yii\web\NotFoundHttpException;

class DefaultController extends \app\modules\member\controllers\DefaultController
{
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->searchMember(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Order model.
     * @param integer $id
     * @return mixed
     * @name 订单详情
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
