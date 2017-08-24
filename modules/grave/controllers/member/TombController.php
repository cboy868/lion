<?php

namespace app\modules\grave\controllers\member;

use app\modules\grave\models\Ins;
use app\modules\grave\models\Portrait;
use app\modules\grave\models\search\TombSearch;
use app\modules\grave\models\Tomb;
use app\modules\order\models\OrderRel;
use app\modules\order\models\OrderRelSearch;
use yii;
use yii\web\NotFoundHttpException;
use yii\base\Model;

class TombController extends \app\core\web\MemberController
{
    public function actions()
    {
        return [
            'pl-upload' => [
                'class' => 'app\core\web\PluploadAction',
            ],
            'ue-upload' => [
                'class' => 'app\core\widgets\Ueditor\UploadAction',
            ],
            'album-upload' => [
                'class' => 'app\core\web\AlbumUploadAction',
                'type' =>'blog_album'
            ]
        ];
    }

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

    public function actionDeads($id)
    {
        $tomb = $this->findModel($id);
        $deads = $tomb->deads;

        if (Yii::$app->request->isPost) {
            if (Model::loadMultiple($deads, Yii::$app->request->post()) && Model::validateMultiple($deads)) {
                foreach ($deads as $model) {
                    $model->save();
                }
                Yii::$app->session->setFlash('success', '逝者信息修改成功');
            }

        }
        $dead_title = Yii::$app->getModule('grave')->params['dead_title'];
        $dead_titles = [];
        foreach ($dead_title as $title) {
            $dead_titles[$title] = $title;
        }

        return $this->render('deads', [
            'model' => $tomb,
            'deads' => $deads,
            'dead_titles' => $dead_titles
        ]);

    }

    public function actionIns($id)
    {
        $tomb = $this->findModel($id);
        return $this->render('ins',[
            'tomb' => $tomb
        ]);
    }

    public function actionPortrait($id)
    {
        $tomb = $this->findModel($id);

        return $this->render('portrait',[
            'tomb' => $tomb
        ]);
    }

    public function actionGoods($id)
    {

        $params = Yii::$app->request->queryParams;

        $params['OrderRelSearch']['tid'] = $id;

        $searchModel = new OrderRelSearch();

        $dataProvider = $searchModel->search($params);

        return $this->render('goods', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'tomb' => $this->findModel($id)
        ]);

    }

    public function actionBury()
    {
        return $this->render('bury');
    }

    /**
     * @name 确认碑文
     */
    public function actionConfirmIns($id)
    {
        $model = Ins::findOne($id);

        $model->confirm_by = Yii::$app->user->id;
        $model->confirm_date = date('Y-m-d');
        $model->is_confirm = Ins::CONFIRM_YES;

        $model->save();

        Yii::$app->session->setFlash('success', '碑文确认成功');

        return $this->redirect(['ins', 'id'=>$model->tomb_id]);
    }

    public function actionConfirmPortrait($id)
    {
        $model = Portrait::findOne($id);

        $model->confirm_by = Yii::$app->user->id;
        $model->confirm_at = date('Y-m-d');
        $model->photo_confirm = $model->photo_processed;
        $model->status = Portrait::STATUS_CONFIRM;

        $model->save();

        Yii::$app->session->setFlash('success', '瓷象确认成功');

        return $this->redirect(['portrait', 'id'=>$model->tomb_id]);
    }

    protected function findModel($id)
    {
        if (($model = Tomb::findOne($id)) !== null) {
            if ($model->user_id != Yii::$app->user->id) {
                throw new yii\web\NotAcceptableHttpException('操作错误');
            }
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
