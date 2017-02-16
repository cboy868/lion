<?php

namespace app\modules\grave\controllers\admin;

use Yii;
use yii\helpers\Url;
use app\modules\grave\models\Tomb;
use app\modules\grave\models\Grave;
use app\modules\grave\models\search\GraveSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\core\base\Upload;

/**
 * DefaultController implements the CRUD actions for Grave model.
 */
class DefaultController extends BackController
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
     * Lists all Grave models.
     * @return mixed
     */
    public function actionIndex()
    {

        $cates = $this->getGraves();

        $searchModel = new GraveSearch();

        $params = Yii::$app->request->queryParams;
        $params['pid'] = isset($params['pid']) ? $params['pid'] : 0;
        $params['GraveSearch']['pid'] = $params['pid'];

        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'cates' => $cates,
            'params' => $params

        ]);
    }


    private function getGraves()
    {
        $tree = Grave::sortTree(['is_leaf'=>0]);

        foreach ($tree as $k => &$v) {
            $v['url'] =Url::toRoute(['index', 'pid'=>$v['id'], 'mod'=>$mod]);
        }

        $tree = \yii\helpers\ArrayHelper::index($tree, 'id');
        $tree = \app\core\helpers\Tree::recursion($tree,0,1);

        return $tree;
    }

    /**
     * Displays a single Grave model.
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
     * Creates a new Grave model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Grave();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {


            $up = Upload::getInstance($model, 'thumb', 'grave');
            if ($up) {
                $up->on(Upload::EVENT_AFTER_UPLOAD, ['app\core\models\Attachment', 'db']);
                $up->save();
                $info = $up->getInfo();
                $model->thumb = $info['mid'];
            }

            if ($model->save(false)) {
                return $this->redirect(['index', 'pid' => $model->pid]);
            }
            
        }
        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Grave model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $up = Upload::getInstance($model, 'thumb', 'grave');
            if ($up) {
                $up->on(Upload::EVENT_AFTER_UPLOAD, ['app\core\models\Attachment', 'db']);
                $up->save();
                $info = $up->getInfo();
                $model->thumb = $info['mid'];
            }

            if ($model->save(false)) {
                return $this->redirect(['index', 'pid' => $model->pid]);
            }

        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Grave model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if (!$model->is_leaf) {
            Yii::$app->getSession()->setFlash('error', '尚有子元素，不可删除。');
            return $this->redirect(['index']);
        }

        $tombs = Tomb::find()->where(['grave_id'=>$id])->all();
        if ($tombs) {
            Yii::$app->getSession()->setFlash('error', '请先删除此墓区下墓位。');
            return $this->redirect(['index']);
        }

        $model->delete();
        Yii::$app->getSession()->setFlash('success', '墓区删除成功。');
        
        return $this->redirect(['index', 'pid'=>$model->pid]);
    }

    /**
     * Finds the Grave model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Grave the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Grave::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
