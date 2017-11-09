<?php

namespace app\modules\shop\controllers\admin;


use app\modules\analysis\models\SettlementRel;

class DefaultController extends \app\core\web\BackController
{
    public function actionIndex()
    {

        return $this->render('index');
    }






}
