<?php

namespace app\modules\sys\controllers\admin;

use app\core\helpers\ArrayHelper;
use app\modules\sys\models\TargetMessage;
use Yii;
use app\modules\sys\models\SourceMessage;
use app\modules\sys\models\SourceMessageSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LanguageController implements the CRUD actions for SourceMessage model.
 */
class LanguageController extends BackController
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
     * Lists all SourceMessage models.
     * @return mixed
     * @name 语言包列表
     */
    public function actionIndex()
    {
        $searchModel = new SourceMessageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $models = $dataProvider->getModels();
        $ids = ArrayHelper::getColumn($models, 'id');
        $trans = TargetMessage::find()->where(['id'=>$ids])->all();

        $result = [];
        foreach ($trans as $v) {
            $result[$v['id']][$v['language']] = $v;
        }

        $i18n_params = Yii::$app->params['i18n'];
        $languages = $i18n_params['languages'];

//        Yii::$app->language = 'en-US';
//        echo Yii::t('app/news', '中国');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'languages' => $languages,
            'trans' => $result
        ]);
    }

    /**
     * Creates a new SourceMessage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @name 添加语言包
     */
    public function actionCreate()
    {
        $model = new SourceMessage();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SourceMessage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @name 修改语言包
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
     * Deletes an existing SourceMessage model.
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
     * @return array
     * @name 添加对应语言翻译
     */
    public function actionTranslate()
    {
        $post = Yii::$app->getRequest()->post();

        $model = $this->findModel($post['id']);
        if (!$model) {
            return $this->json(null, null, 0);
        }

        $where = [
            'id' => $post['id'],
            'language' => $post['language']
        ];

        $tmodel = TargetMessage::find()->where($where)->one();

        if (!$tmodel) {
            $tmodel = new TargetMessage();
            $tmodel->load($where, '');
        }
        $tmodel->translation = $post['translation'];

        if ($tmodel->save()) {
            return $this->json();
        }

    }

    /**
     * Finds the SourceMessage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SourceMessage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SourceMessage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
