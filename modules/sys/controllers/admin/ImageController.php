<?php

namespace app\modules\sys\controllers\admin;

use Yii;
use app\modules\sys\models\ImageConfig;
use app\modules\sys\models\ImageConfigSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\Model;

/**
 * ImageController implements the CRUD actions for ImageConfig model.
 */
class ImageController extends BackController
{



    public static $resname = [
        'goods' => '商品',
        'focus' => '焦点图'
    ];



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
     * Lists all ImageConfig models.
     * @return mixed
     */
    public function actionIndex()
    {

        ImageConfig::writeFile();

        $models = ImageConfig::find()->where(['res_name'=>array_keys(self::$resname)])->indexBy('res_name')->all();


        $request = Yii::$app->request;

        foreach (self::$resname as $k => $v) {
            if (!isset($models[$k])) {
                $models[$k] = new ImageConfig();
                $models[$k]->loadDefaultValues();
            }
        }


        if ($request->isPost) {
            $res_name = $request->post('ImageConfig')['res_name'];

            if ($models[$res_name]->load($request->post()) && $models[$res_name]->save()) {
                return $this->redirect(['index']);
            }

        }




        


        return $this->render('index', [
                'models' => $models,
                'res'    => self::$resname
            ]);



        // $searchModel = new ImageConfigSearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        // $model = new ImageConfig();

        // return $this->render('index', [
        //     'searchModel' => $searchModel,
        //     'dataProvider' => $dataProvider,
        //     'model' => $model
        // ]);
    }

    /**
     * Displays a single ImageConfig model.
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
     * Creates a new ImageConfig model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ImageConfig();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ImageConfig model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ImageConfig model.
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
     * Finds the ImageConfig model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ImageConfig the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ImageConfig::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
