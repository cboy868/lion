<?php

namespace app\modules\cms\controllers\admin;

use app\modules\mod\models\Module;
use Yii;
use app\modules\cms\models\Category;
use app\modules\cms\models\CategorySearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\core\base\Upload;

/**
 * PostCategoryController implements the CRUD actions for PostCategory model.
 */
class CategoryController extends BackController
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
     * Lists all PostCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategorySearch();

        $params = Yii::$app->request->queryParams;
        $params['CategorySearch']['pid'] = 0;
        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }

    /**
     * Displays a single PostCategory model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $mod = $this->findModel($id);
        $searchModel = new CategorySearch();
        $params = Yii::$app->request->queryParams;
        $params['CategorySearch']['pid'] = $id;
        $dataProvider = $searchModel->search($params);

        $current = $this->findModel($id);

        return $this->render('view', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'mod' => $mod,
            'current' => $current
        ]);
    }

    /**
     * Creates a new PostCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->getRequest();

        $model = new Category();
        $model->res_name = $request->get('res_name');
        if ($request->get('pid')) {
            $model->pid = $request->get('pid');
        }

        $transaction = Yii::$app->db->beginTransaction();

        if (Yii::$app->request->isPost) {

            try {
                $model->load($request->post());
                $upload = Upload::getInstance($model, 'covert', 'cms_category');

                if ($upload) {
                    $upload->on(Upload::EVENT_AFTER_UPLOAD, ['app\core\helpers\Image', 'thumb']);
                    $upload->on(Upload::EVENT_AFTER_UPLOAD, ['app\core\models\Attachment', 'db']);
                    $upload->save();

                    $info = $upload->getInfo();

                    $model->thumb = $info['mid'];
                }

                if ($model->pid != 0) {
                    $model->res_name = $model->parent->res_name;
                }

                $model->save();

                if ($model->pid == 0) {
                    $model->res_name = $model->id;
                    $model->save();

                    $mod = new Module();
                    $mod->mid = $model->id;
                    $mod->module = 'post';
                    $mod->name = $model->name;
                    $mod->save();
                    Module::createModels($mod);

                    $mod = new Module();
                    $mod->mid = $model->id;
                    $mod->module = 'album';
                    $mod->name = $model->name;
                    $mod->save();
                    Module::createModels($mod);
                }

                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }

            $uri = $_SERVER["HTTP_REFERER"];

            return $this->redirect($uri);
        } 

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $upload = Upload::getInstance($model, 'covert', 'cms_category');

            if ($upload) {
                $upload->on(Upload::EVENT_AFTER_UPLOAD, ['app\core\helpers\Image', 'thumb']);
                $upload->on(Upload::EVENT_AFTER_UPLOAD, ['app\core\models\Attachment', 'db']);
                $upload->save();

                $info = $upload->getInfo();

                $model->thumb = $info['mid'];
            }

            if ($model->save()) {
                $uri = $_SERVER["HTTP_REFERER"];

                return $this->redirect($uri);
            }
        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
        
    }

    /**
     * Deletes an existing PostCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $mid = $model->res_name;
        $model->delete();

        if ($model->pid == 0) {
            $mods = Module::find()->where(['mid'=>$mid])->all();

            foreach ($mods as $m) {
                Module::deleteMod($m);
                $m->delete();
            }

            Yii::$app->db->createCommand()
                ->delete(Category::tableName(),[
                    'res_name' => $mid,
                ])->execute();
        }

        return $this->redirect($_SERVER["HTTP_REFERER"]);
    }

    /**
     * Finds the PostCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PostCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
