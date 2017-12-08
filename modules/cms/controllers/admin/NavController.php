<?php

namespace app\modules\cms\controllers\admin;

use app\modules\cms\models\LgNav;
use app\modules\news\models\LgNews;
use Yii;
use app\modules\cms\models\Nav;
use app\modules\cms\models\NavSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\Model;

/**
 * NavController implements the CRUD actions for Nav model.
 */
class NavController extends BackController
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
     * Lists all Nav models.
     * @return mixed
     * @name 前台菜单管理
     */
    public function actionIndex()
    {
        $searchModel = new NavSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Nav model.
     * @param integer $id
     * @return mixed
     * @name 明细
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Nav model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @name 添加菜单
     */
    public function actionCreate()
    {
        $model = new Nav();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Nav model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @name 修改前台菜单
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionLanguage($id)
    {
        $model = $this->findModel($id);

        $params = Yii::$app->params['i18n'];
        $lgs = array_keys($params['languages']);
        $data['model'] = $model;

        $lg_models = LgNav::find()->where(['language'=>$lgs])
            ->andWhere(['nav_id'=>$model->id])
            ->indexBy('language')
            ->all();


        foreach ($lgs as $v) {
            if (!array_key_exists($v, $lg_models)) {
                $lg_models[$v] = new LgNav();
                $lg_models[$v]->language = $v;
                $lg_models[$v]->nav_id = $id;
            }
        }

        if (Model::loadMultiple($lg_models, \Yii::$app->request->post()) && Model::validateMultiple($lg_models)) {

            foreach ($lg_models as $lg_model) {
                $lg_model->save(false);
            }

            return $this->redirect(['index']);
        }

        $data['lg_models'] = $lg_models;
        $data['languages'] = $params['languages'];
        return $this->render('lanuage', $data);
    }

    /**
     * Deletes an existing Nav model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @name 删除前台菜单
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Nav model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Nav the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Nav::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
