<?php

namespace app\modules\sys\controllers\admin;

use Yii;
use app\modules\sys\models\Menu;
use app\modules\sys\models\MenuSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\sys\models\AuthPermission;

/**
 * MenuController implements the CRUD actions for Menu model.
 */
class MenuController extends \app\core\web\BackController
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
     * @name 菜单列表
     * @return mixed
     */
    public function actionIndex()
    {

        $model = new Menu();
        return $this->render('index', [
            'model' => $model,
            'menu'  => $model->getMenus(2)
        ]);
    }

    /**
     * Displays a single Menu model.
     * @param integer $id
     * @return mixed
     */
    // public function actionView($id)
    // {
    //     return $this->render('view', [
    //         'model' => $this->findModel($id),
    //     ]);
    // }

    /**
     * @name 添加菜单
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        // $this->layout = '@base/back/views/layouts/form';
        $model = new Menu();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @name 修改菜单
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
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
     * @name 删除菜单
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
     * @name 获取方法
     */
    public function actionItems($parent, $type=1)
    {
        switch ($type) {
            case 1:
                $mu = AuthPermission::getCtrls($parent);
                break;
            case 2:
                $mu = AuthPermission::getMethods($parent);
                break;
            
            default:
                # code...
                break;
        }

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'status' => 200,
            'data' => $mu,
        ];
    }

    /**
     * Finds the Menu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Menu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Menu::findOne($id)) !== null) {
            if (!$model->auth_name) {
                return $model;
            }
            $auth = explode('/', $model->auth_name);
            $model->mod = $auth[0];
            $model->ctrl = $auth[0].'/'.$auth[1];
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
