<?php

namespace app\modules\sys\controllers\admin;

use Yii;
use app\core\models\Area;
use app\modules\sys\models\AreaSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AreaController implements the CRUD actions for Area model.
 */
class AreaController extends BackController
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
     * Lists all Area models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new AreaSearch();
        $params = Yii::$app->request->queryParams;
        $params['AreaSearch']['pid'] = 0;

        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Area model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Area model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Area();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Area model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
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
     * Deletes an existing Area model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionChild($id)
    {
        $items = Area::find()->where(['pid'=>$id])->all();

        return $this->json($items, null, 1);
    }



    public function actionGenerateJs()
    {
        $list = Area::find()->where(['<=', 'level', 3])->asArray()->all();
        $pro = $city = $zone = [];
        foreach ($list as $k => $v) {
            if ($v['level'] == 1) {
                $pro[$v['id']] = $v['name'];
            } else if ($v['level'] == 2) {
                $city[$v['pid']][$v['id']] = $v['name'];
            } else if ($v['level'] == 3) {
                $zone[$v['pid']][$v['id']] = $v['name'];
            }
        }
        $js_content=<<<JS
/**
* 地区 JS 库 此文件由系统生成
* @copyright http://www.zhuo-xun.com
* @date %s
*/
var pro_list = %s;
var city_list = %s;
var zone_list = %s;
JS;
        $js_content = sprintf($js_content, date('Y-m-d H:i:s'), json_encode($pro), json_encode($city), json_encode($zone));
        $file_name = Yii::getAlias('@app/web/static/site/area_tmp.js');
        if (@file_put_contents($file_name, $js_content)) {
            Yii::$app->session->setFlash('success', sprintf('成功生工生成 js 库地区文件 <br /> 文件大小 %s <br />文件路径 %s', filesize($file_name), $file_name));
        }
        return $this->redirect(['index']);
    }

//    public function generateAreaJs()
//    {
//        $list = Area::find()->where(['<=', 'level', 3])->asArray()->all();
//        $result = [];
//        foreach ($list as $key => $value) {
//            if ($value['level'] <= 3) {
//                $result[$value['pid']][$value['id']] = $value['name'];
//            }
//        }
//        $js = '/**
//* 地区 %s 级 JS 库 此文件由系统生成
//* @date %s
//*/
//var area =
//';
//        $js = sprintf($js, 3, date('Y-m-d H:i:s'));
//        $js_content = $js.json_encode($result);
//        $file_name = Yii::getAlias('@app/web/static/site/area.js');
//        if (@file_put_contents($file_name, $js_content)) {
//            Yii::$app->session->setFlash('success', sprintf('成功生工生成 js 库地区文件 <br /> 文件大小 %s <br />文件路径 %s', filesize($file_name), $file_name));
//        }
//        return $this->redirect(['index']);
//    }


    /**
     * Finds the Area model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Area the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Area::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
