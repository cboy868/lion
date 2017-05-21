<?php

namespace app\modules\order\controllers\member;


use yii;
use app\modules\shop\models\Gooods;
use app\modules\shop\models\Sku;
use app\modules\order\models\Order;
use app\modules\order\models\Pay;
use app\core\libs\Fpdf;


class DefaultController extends \app\modules\member\controllers\DefaultController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
