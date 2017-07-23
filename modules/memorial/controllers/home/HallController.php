<?php

namespace app\modules\memorial\controllers\home;

use app\core\models\Comment;
use app\modules\memorial\models\Memorial;
use app\modules\memorial\models\Pray;
use yii;

class HallController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
