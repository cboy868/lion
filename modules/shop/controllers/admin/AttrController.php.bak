<?php

namespace app\modules\shop\controllers\admin;

use Yii;
use app\core\helpers\ArrayHelper;

use app\modules\shop\models\Attr;
use app\modules\shop\models\search\Attr as AttrSearch;
use app\modules\shop\models\AttrVal;
use app\modules\shop\models\search\AttrVal as AttrValSearch;

use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\shop\models\Type;
use app\core\base\Upload;
use app\core\models\AttachmentRel;
/**
 * AttrController implements the CRUD actions for Attr model.
 */
class AttrController extends BackController
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
     * Lists all Attr models.
     * @return mixed
     * @name 属性管理
     */
    public function actionIndex()
    {
        $types = Type::find()->all();
        $types = ArrayHelper::index($types, 'id');
        
        $searchModel = new AttrSearch();

        $param['Attr']['is_spec'] = Attr::SPEC_NO;



        $params = ArrayHelper::merge(Yii::$app->request->queryParams, $param);

        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'types' => $types
        ]);
    }

    /**
     * Displays a single Attr model.
     * @param integer $id
     * @return mixed
     * @name 属性详情
     */
    public function actionView($id)
    {

        $searchModel = new AttrValSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);
        $model = $this->findModel($id);
        $valmodel = new AttrVal();

        if ($valmodel->load(Yii::$app->request->post())) {
            if ($valmodel->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } 
        } else {
            return $this->render('view', [
                'model' => $model,
                'list' => $model->getVals(),
                'dataProvider' => $dataProvider,
                'valmodel' => $valmodel
            ]);
        }

    }

    /**
     * @name 添加属性值 
     */
    public function actionCreateVal()
    {
        $model = new AttrVal();

        if ($model->load(Yii::$app->request->post())) {

            $upload = Upload::getInstance($model, 'thumb', 'shop_attr');

            if ($upload) {
                $upload->save();

                $info = $upload->getInfo();
                $model->thumb = $info['path'] . '/' . $info['fileName'];
            }

            if ($model->save()) {
                if ($upload) {
                    AttachmentRel::updateResId('shop_attr', $info['mid'], $model->id);
                }
                
                return $this->redirect(['view', 'id'=>$model->attr_id]);
            }

            
        } else {
            $request = Yii::$app->getRequest();

            $model->type_id = $request->get('tid');
            $model->attr_id = $request->get('aid');

            return $this->renderAjax('create-val', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @name 修改属性值 
     */
    public function actionUpdateVal($id)
    {
        $model = $this->findValModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $upload = Upload::getInstance($model, 'thumb', 'shop_attr');
            if ($upload) {
                $upload->save();
                $info = $upload->getInfo();
                
                $model->thumb= $info['path'] . '/' . $info['fileName'];
                AttachmentRel::updateResId('shop_attr', $info['mid'], $model->id);
            }

            if ($model->save()) {
                return $this->redirect(['view', 'id'=>$model->attr_id]);
            }
            
        } else {
            return $this->renderAjax('update-val', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @name 删除属性值 
     */
    public function actionDeleteVal($id)
    {
        $model = $this->findValModel($id);//->delete();
        $attr_id = $model->attr_id;
        $model->delete();

        return $this->redirect(['view', 'id'=>$attr_id]);
    }

    /**
     * Creates a new Attr model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @name 添加属性 
     */
    public function actionCreate()
    {
        $model = new Attr();

        if ($model->load(Yii::$app->request->post())) {

            $model->is_spec = Attr::SPEC_NO;

            if ($model->save()) {
                return $this->redirect(['index']);
            }
            
        }
        $model->type_id = Yii::$app->request->get('type_id');

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Attr model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @name 修改属性 
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $model->is_spec = Attr::SPEC_NO;

            if ($model->save()) {
                return $this->redirect(['index']);
            }
            
        }
        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Attr model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @name 删除属性
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Attr model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Attr the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Attr::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findValModel($id)
    {
        if (($model = AttrVal::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
