<?php

namespace app\modules\shop\controllers\admin;

use Yii;
use app\modules\shop\models\Type;
use app\modules\shop\models\search\Type as TypeSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\modules\shop\models\Attr;
use app\modules\shop\models\AttrVal;

use app\modules\shop\models\search\Attr as AttrSearch;
use app\modules\shop\models\search\AttrVal as AttrValSearch;
use app\core\base\Upload;
use app\core\models\AttachmentRel;


use app\core\helpers\ArrayHelper;

/**
 * TypeController implements the CRUD actions for Type model.
 */
class TypeController extends BackController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'spec-delete' => ['post']
                ],
            ],
        ];
    }

    /**
     * Lists all Type models.
     * @return mixed
     * @name 类型列表
     */
    public function actionIndex()
    {
        $searchModel = new TypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Type model.
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
     * Creates a new Type model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @name 添加类型
     */
    public function actionCreate()
    {
        $model = new Type();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Type model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @name 更新
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Type model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @name 删除
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Type model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Type the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Type::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionSpec($id)
    {

        $type = Type::findOne($id);
        
        $searchModel = new AttrSearch();

        $param['Attr']['is_spec'] = Attr::SPEC_YES;
        $param['Attr']['type_id'] = $id;
        $params = ArrayHelper::merge(Yii::$app->request->queryParams, $param);
        $dataProvider = $searchModel->search($params);
        return $this->render('spec', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'type' => $type
        ]);

    }

    /**
     * @param $id
     * @return string
     * @name 属性管理
     */
    public function actionAttr($id)
    {

        $type = Type::findOne($id);
        
        $searchModel = new AttrSearch();

        $param['Attr']['is_spec'] = Attr::SPEC_NO;
        $param['Attr']['type_id'] = $id;
        $param['Attr']['status'] = Attr::STATUS_NORMAL;
        $params = ArrayHelper::merge(Yii::$app->request->queryParams, $param);
        $dataProvider = $searchModel->search($params);
        return $this->render('attr', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'type' => $type
        ]);

    }


    /**
     * @name 规格详细
     */
    // public function actionSpecView($id)
    // {

    //     $searchModel = new AttrValSearch();
    //     $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);
    //     $model = $this->findSpecModel($id);
    //     $valmodel = new AttrVal();
    //     $valmodel->attr_id = $id;
    //     $valmodel->type_id = $model->type_id;

    //     if ($valmodel->load(Yii::$app->request->post())) {

    //         $upload = Upload::getInstance($valmodel, 'thumb', 'shop_attr');
    //         if ($upload) {
    //             $upload->on(Upload::EVENT_AFTER_UPLOAD, ['app\core\models\Attachment', 'db']);
    //             $upload->save();
    //             $info = $upload->getInfo();

    //             $valmodel->thumb = $info['mid'];//$info['path'] . '/' . $info['fileName'];
    //         }

    //         if ($valmodel->save()) {
    //             if ($upload) {
    //                 AttachmentRel::updateResId('shop_attr', $info['mid'], $model->id);
    //             }
                
    //             return $this->redirect(['spec-view', 'id'=>$valmodel->attr_id]);
    //         }


    //     } else {
    //         return $this->render('spec-view', [
    //             'model' => $model,
    //             'list' => $model->getVals(),
    //             'dataProvider' => $dataProvider,
    //             'valmodel' => $valmodel
    //         ]);
    //     }

    // }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @name 添加规格值
     */
    public function actionSpecCreateVal($id)
    {
        $spec = $this->findSpecModel($id);
        $model = new AttrVal();

        if ($model->load(Yii::$app->request->post())) {

            $upload = Upload::getInstance($model, 'thumb', 'shop_attr');

            if ($upload) {
                $upload->on(Upload::EVENT_AFTER_UPLOAD, ['app\core\models\Attachment', 'db']);
                $upload->save();

                $info = $upload->getInfo();
                $model->thumb = $info['mid'];// . '/' . $info['fileName'];
            }

            if ($model->save()) {
                if ($upload) {
                    AttachmentRel::updateResId('shop_attr', $info['mid'], $model->id);
                }

                $rdi = $spec->is_spec ? 'spec' : 'attr';
                return $this->redirect([$rdi, 'id'=>$spec->type_id]);
            }
            
        } else {
            $request = Yii::$app->getRequest();

            $model->type_id = $spec->type_id;
            $model->attr_id = $id;

            return $this->renderAjax('spec-create-val', [
                'model' => $model,
            ]);
        }
    }


    /**
     * @name 修改规格值
     */
    public function actionSpecUpdateVal($id)
    {
        $model = $this->findSpecValModel($id);

        $thumb = $model->thumb;


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $upload = Upload::getInstance($model, 'thumb', 'shop_attr');
            if ($upload) {
                $upload->on(Upload::EVENT_AFTER_UPLOAD, ['app\core\models\Attachment', 'db']);
                $upload->save();
                $info = $upload->getInfo();
                
                $model->thumb= $info['mid'];//
                AttachmentRel::updateResId('shop_attr', $info['mid'], $model->id);
            } else {
                $model->thumb = $thumb;
            }



            if ($model->save()) {


                $rdi = $spec->is_spec ? 'spec' : 'attr';
                return $this->redirect([$rdi, 'id'=>$model->type_id]);
            }
            
        } else {
            return $this->renderAjax('spec-update-val', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @name 删除规格值
     */
    public function actionSpecDeleteVal($id)
    {
        $model = $this->findSpecValModel($id);//->delete();
        $attr_id = $model->attr_id;
        $model->delete();

        $rdi = $spec->is_spec ? 'spec' : 'attr';

        return $this->redirect([$rdi, 'id'=>$model->type_id]);
    }

    /**
     * Creates a new Attr model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @name 添加规格
     */
    public function actionSpecCreate($type_id)
    {
        $model = new Attr();
        $model->type_id = $type_id;

        if ($model->load(Yii::$app->request->post())) {

            $model->is_spec = Attr::SPEC_YES;

            if ($model->save()) {
                return $this->redirect(['spec', 'id'=>$type_id]);
            }
        } 

        return $this->renderAjax('spec-create', [
            'model' => $model,
        ]);
    }

    /**
     * @param $type_id
     * @return string|\yii\web\Response
     * @name 添加属性值
     */
    public function actionAttrCreate($type_id)
    {
        $model = new Attr();
        $model->type_id = $type_id;

        if ($model->load(Yii::$app->request->post())) {

            $model->is_spec = Attr::SPEC_NO;

            if ($model->save()) {
                return $this->redirect(['attr', 'id'=>$type_id]);
            }
        } 

        return $this->renderAjax('attr-create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Attr model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @name 修改规格
     */
    public function actionSpecUpdate($id)
    {
        $model = $this->findSpecModel($id);

        if ($model->load(Yii::$app->request->post())) {
            // $model->is_spec = Attr::SPEC_YES;
            if ($model->save()) {
                $rdi = $spec->is_spec ? 'spec' : 'attr';
                return $this->redirect([$rdi, 'id'=>$model->type_id]);
            }
        } 

        return $this->renderAjax('spec-update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Attr model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed\
     * @name 删除规格
     */
    public function actionSpecDelete($id)
    {
        $model = $this->findSpecModel($id);

        $outerTransaction = Yii::$app->db->beginTransaction();
        try {
            $model->delete();
            Yii::$app->db->createCommand()->delete('{{%shop_av}}', ['attr_id'=>$id])->execute();

            $outerTransaction->commit();
        } catch (Exception $e) {
            $outerTransaction->rollBack();
        }
        $rdi = $spec->is_spec ? 'spec' : 'attr';
        return $this->redirect([$rdi, 'id'=>$model->type_id]);
    }

    /**
     * Finds the Attr model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Attr the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findSpecModel($id)
    {
        if (($model = Attr::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findSpecValModel($id)
    {
        if (($model = AttrVal::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
