<?php

namespace app\modules\grave\controllers\admin;

use Yii;
use app\modules\grave\models\Card;
use app\modules\grave\models\CardRel;

use app\modules\grave\models\CardSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\Model;
use app\core\helpers\ArrayHelper;

/**
 * CardController implements the CRUD actions for Card model.
 */
class CardController extends BackController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Card models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CardSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Card model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Card model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $card = Card::find()->where(['tomb_id'=>$id])->one();
        if (!$card) {
            $card = new Card();
            $card->tomb_id = $id;
        }
        $model = new CardRel();
        $model->tomb_id = $id;

        if ($model->load(Yii::$app->request->post()) ) {
            $model->total = date('Y', strtotime($model->end)) - date('Y', strtotime($model->start));
            if ($card->isNewRecord) {
                $card->start = $model->start;
                $card->end   = $model->end;
                // $card->total = date('Y', strtotime($model->end)) - date('Y', strtotime($model->start));
                $card->created_by = Yii::$app->user->id;
                $card->save();
            }
            $model->card_id = $card->id;
            $model->total = date('Y', strtotime($model->end)) - date('Y', strtotime($model->start));
            $model->save();

            return $this->redirect(Yii::$app->request->referrer);
        } else {

            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }


    /**
     * @name 修改墓证
     */
    public function actionUpdate($id)
    {

        $model = Card::find($id)->where(['tomb_id'=>$id])->one();
        $rels =  ArrayHelper::index($model->rels, 'id');

        if (Model::loadMultiple($rels, \Yii::$app->request->post()) && Model::validateMultiple($rels)) {
             foreach ($rels as $rel) {
                $rel->total = date('Y', strtotime($rel->end)) - date('Y', strtotime($rel->start));
                $rel->save(false);
            }

            return $this->redirect(Yii::$app->request->referrer);
        } else {
            return $this->renderAjax('update', ['rels'=>$rels, 'model'=>$model]);
        }
    }

    /**
     * Deletes an existing Card model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Card model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Card the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Card::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
