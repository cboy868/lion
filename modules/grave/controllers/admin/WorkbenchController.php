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
        return $this->render('index');
    }

    public function actionTomb()
    {

        $searchModel = new TombSearch();

        return $this->renderAjax('tomb', [
            'model' => $searchModel
        ]);
    }
}
