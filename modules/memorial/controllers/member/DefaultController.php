<?php

namespace app\modules\memorial\controllers\member;

use yii;
use app\modules\memorial\models\Memorial;

class DefaultController extends \app\core\web\MemberController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @name 添加纪念馆
     */
    public function actionCreate()
    {
    	$model = new Memorial();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {


            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
}
