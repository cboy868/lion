<?php

namespace app\modules\analysis\controllers\admin;


use app\modules\analysis\models\SettlementTomb;

class ClientController extends \app\core\web\BackController
{
    public function actionIndex()
    {
        return $this->render('index');
    }


    /**
     * @name 总接待数量统计
     */
    public function actionNum()
    {

    }

    /**
     * @name 导购员接待量统计
     */
    public function actionGuide()
    {

    }

}
