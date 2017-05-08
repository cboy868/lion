<?php

namespace app\modules\grave\controllers\admin;

use app\core\models\Attachment;
use app\core\models\AttachmentRel;
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

    public function actions()
    {
        return [
            'web-upload' => [
                'class' => 'app\core\web\WebuploadAction',
            ],
            'ue-upload' => [
                'class' => 'app\core\widgets\Ueditor\UploadAction',
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
        $tree = Grave::sortTree(['level'=>1]);

        foreach ($tree as $k => &$v) {
            $v['url'] =Url::toRoute(['index', 'pid'=>$v['id']]);
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

            $post = Yii::$app->request->post();

            if (isset($post['mid']) && !empty($post['mid'])) {
                AttachmentRel::updateResId('grave', $post['mid'], $model->id);
                $model->thumb = $post['mid'][0];
            }

            if ($model->save(false)) {
                return $this->redirect(['index', 'pid' => $model->pid]);
            }
            
        }
        $model->loadDefaultValues();
        return $this->render('create', [
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
            $post = Yii::$app->request->post();

            if (isset($post['mid']) && !empty($post['mid'])) {
                AttachmentRel::updateResId('grave', $post['mid'][0], $model->id);
                if (!$model->thumb) {
                    $model->thumb = $post['mid'][0];
                }
            }

            if ($model->save(false)) {
                return $this->redirect(['index', 'pid' => $model->pid]);
            }

        }

        //已上传图片
        $imgs = AttachmentRel::getByRes('grave', $id, '100x100');

        return $this->render('update', [
            'model' => $model,
            'imgs' => $imgs
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

    public function actionCover()
    {
        $post = Yii::$app->getRequest()->post();

        $model = self::findModel($post['grave_id']);
        $model->thumb = $post['thumb'];
        if ($model->save()) {
            return $this->json();
        }

        return $this->json(null, '修改封面失败', 0);

    }

    public function actionDelImg()
    {
        $post = Yii::$app->getRequest()->post();

        $model = Attachment::findOne($post['thumb']);
        $model->status = Attachment::STATUS_DEL;
        if ($model->save()) {
            return $this->json();
        }


        return $this->json(null, '图片删除失败', 0);
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
