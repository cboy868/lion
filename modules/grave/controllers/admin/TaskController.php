<?php

namespace app\modules\grave\controllers\admin;

use Yii;
use app\modules\task\models\search\TaskSearch;
use app\core\helpers\ArrayHelper;
use app\modules\task\models\Goods;

/**
 * TombController implements the CRUD actions for Tomb model.
 */
class TaskController extends \app\modules\task\controllers\admin\DefaultController
{
    /**
     * @return string
     * @name 任务列表
     */
    public function actionIndex()
    {
        $searchModel = new TaskSearch();
        $params = Yii::$app->request->queryParams;
        $params['TaskSearch']['res_name'] = 'tomb';

        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


}
