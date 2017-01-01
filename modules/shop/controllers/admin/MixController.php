<?php

namespace app\modules\shop\controllers\admin;

use Yii;
use app\core\helpers\ArrayHelper;
use app\modules\shop\models\Mix;
use app\modules\shop\models\MixCate;
use app\modules\shop\models\search\Mix as MixSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MixController implements the CRUD actions for Mix model.
 * todo 删除和编辑功能
 */
class MixController extends BackController
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
     * Lists all Mix models.
     * @return mixed
     * @name 源材料管理
     */
    public function actionIndex()
    {
        $cates = MixCate::find()->asArray()->all();
        $cates = ArrayHelper::map($cates, 'id', 'name');

        $searchModel = new MixSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $models = $dataProvider->getModels();
        $mix = ArrayHelper::toArray($models);
        $result = [];

        foreach ($mix as $k => $v) {
            $result[$v['mix_cate']][] = $v;
        }

        return $this->render('index', [
            'cates' => $cates,
            'mix' => $result,
            'searchModel' => $searchModel,
            // 'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Mix model.
     * @param integer $id
     * @return mixed
     * @name 源材料详情
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Mix model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @name 添加源材料
     */
    public function actionCreate()
    {
        $model = new Mix();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @name 添加原材料分类
     */
    public function actionAdd()
    {
        $req = Yii::$app->getRequest();


        $model = new Mix();
        $model->mix_cate = $req->post('mix_cate');
        $model->name = $req->post('name');

        if ($model->save()) {
            return $this->json(['id'=>$model->id], null, 1);
        }

        return $this->json(null, '保存失败', 0);
    }

    /**
     * Updates an existing Mix model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @name 修改源材料
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
     * Deletes an existing Mix model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @name 删除源材料
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @name ajax方式删除 
     */
    public function actionDel()
    {
        $id = Yii::$app->getRequest()->post('id');
        if ($this->findModel($id)->delete()) {
            return $this->json(null, null, 1);
        }
        return $this->json(null, '删除失败', 0);
    }
    /**
     * @name 编辑
     */
    public function actionEdit()
    {
        $id = Yii::$app->getRequest()->post('id');
        $name = Yii::$app->getRequest()->post('name');

        if (!$name) {
            return $this->json(null, '食材名为空', 0);
        }

        $model = $this->findModel($id);

        if ($model->name == $name) {
            return $this->json(null, '新食材与原食材名相同', 0);
        }
        $model->name=$name;
        if ($model->save()) {
            return $this->json(null, null, 1);
        }
        return $this->json(null, '编辑失败', 0);
    }

    /**
     * Finds the Mix model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Mix the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Mix::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
