<?php

namespace app\modules\grave\controllers\member;

use app\modules\grave\models\search\TombSearch;
use app\modules\grave\models\Tomb;
use yii;
use yii\web\NotFoundHttpException;

class TombController extends \app\core\web\MemberController
{
    public function actionIndex()
    {
        $params = Yii::$app->request->queryParams;

        $params['TombSearch']['user_id'] = Yii::$app->user->id;
        $searchModel = new TombSearch();
        $dataProvider = $searchModel->searchMember($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTomb($id)
    {
        return $this->render('tomb',[
            'model' => $this->findModel($id)
        ]);
    }

    public function actionDeads()
    {
        return $this->render('deads');
    }

    public function actionIns()
    {
        return $this->render('ins');
    }

    public function actionPortrait()
    {
        return $this->render('portrait');
    }

    public function actionGoods()
    {
        return $this->render('goods');
    }

    public function actionBury()
    {
        return $this->render('bury');
    }

    protected function findModel($id)
    {
        if (($model = Tomb::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
