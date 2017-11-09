<?php
namespace app\modules\analysis\controllers\admin;

// use app\modules\grave\models\Tomb;
use app\modules\analysis\models\SettlementTomb;

class DefaultController extends \app\core\web\BackController
{
    /**
     * @return string
     * @name 数据统计首页
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @return string
     * @name 办事处/业务员 统计
     */
    public function actionAgency()
    {
        return $this->render('agency');
    }
}
