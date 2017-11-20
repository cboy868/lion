<?php

namespace app\modules\mess\controllers\admin;

use app\modules\mess\models\MessMenuCategory;
use Yii;
use app\modules\mess\models\MessMenu;
use app\modules\mess\models\SearchMessMenu;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\core\base\Upload;
/**
 * MenuController implements the CRUD actions for MessMenu model.
 */
class MenuController extends BackController
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
     * Lists all MessMenu models.
     * @return mixed
     */
    public function actionIndex()
    {
        $params = Yii::$app->request->queryParams;

        if (isset($params['category_id']) && $params['category_id']) {
            $params['SearchMessMenu']['category_id'] = $params['category_id'];
        }

        if (isset($params['SearchMessMenu']['category_id']) && $params['SearchMessMenu']['category_id']) {
            $params['category_id'] = $params['SearchMessMenu']['category_id'];
        }

        $searchModel = new SearchMessMenu();
        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'cates' => MessMenuCategory::sel(),
            'params' => $params
        ]);
    }

    /**
     * Displays a single MessMenu model.
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
     * Creates a new MessMenu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MessMenu();

        $req = Yii::$app->getRequest();

        $transaction = Yii::$app->db->beginTransaction();

        if (Yii::$app->request->isPost) {

            try {
                $model->load($req->post());
                $upload = Upload::getInstance($model, 'cover', 'mess_menu');

                if ($upload) {
                    $upload->on(Upload::EVENT_AFTER_UPLOAD, ['app\core\helpers\Image', 'thumb']);
                    $upload->on(Upload::EVENT_AFTER_UPLOAD, ['app\core\models\Attachment', 'db']);
                    $upload->save();

                    $info = $upload->getInfo();
                    $model->cover = $info['mid'];
                }
                $model->save();

                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }


            return $this->redirect(['index']);
        }


        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MessMenu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldcover = $model->cover;

        if ($model->load(Yii::$app->request->post())) {
            $upload = Upload::getInstance($model, 'cover', 'mess_menu');

            if ($upload) {
                $upload->on(Upload::EVENT_AFTER_UPLOAD, ['app\core\helpers\Image', 'thumb']);
                $upload->on(Upload::EVENT_AFTER_UPLOAD, ['app\core\models\Attachment', 'db']);
                $upload->save();

                $info = $upload->getInfo();

                $model->cover = $info['mid'];
            } else{
                $model->cover = $oldcover;
            }

            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }


        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MessMenu model.
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
     * Finds the MessMenu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MessMenu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MessMenu::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
