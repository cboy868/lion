<?php

namespace app\modules\grave\controllers\admin;

use Yii;
use app\modules\grave\models\search\TombSearch;

/**
 * WithdrawController implements the CRUD actions for Withdraw model.
 */
class WorkbenchController extends \app\core\web\BackController
{
    /**
     * @return string
     * @name 工作台
     */
    public function actionIndex()
    {

        $searchModel = new TombSearch();

        return $this->render('index', [

                'model' => $searchModel
            ]);
    }

    /**
     * @return string
     * @name 查找墓位
     */
    public function actionTomb()
    {
        $searchModel = new TombSearch();

        return $this->renderAjax('tomb', [
            'model' => $searchModel
        ]);
    }

    /**
     * @return string
     * @name 墓位列表
     */
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
