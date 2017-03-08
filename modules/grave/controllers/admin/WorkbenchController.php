<?php

namespace app\modules\grave\controllers\admin;

use Yii;
use app\modules\grave\models\search\TombSearch;

/**
 * WithdrawController implements the CRUD actions for Withdraw model.
 */
class WorkbenchController extends \app\core\web\BackController
{
    public function actionIndex()
    {

        $searchModel = new TombSearch();

        return $this->render('index', [

                'model' => $searchModel
            ]);
    }

    public function actionTomb()
    {

        $searchModel = new TombSearch();

        return $this->renderAjax('tomb', [
            'model' => $searchModel
        ]);
    }

    public function actionList()
    {
        $searchModel = new TombSearch();

        $params = Yii::$app->request->queryParams;

        $dataProvider = $searchModel->search($params);


        return $this->renderAjax('list', [
            'dataProvider' => $dataProvider,
            'searchModel'=> $searchModel,
        ]);
    }
}
