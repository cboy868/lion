<?php

namespace app\modules\grave\controllers\admin;

use Yii;
use app\modules\task\models\Info;
use app\modules\task\models\InfoForm;
use app\modules\task\models\search\InfoSearch;
use app\core\helpers\ArrayHelper;
use app\modules\task\models\Goods;

/**
 * TombController implements the CRUD actions for Tomb model.
 */
class TaskController extends \app\modules\task\controllers\admin\DefaultController
{

    public function actionInfo()
    {
        $searchModel = new InfoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('info', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreateInfo()
    {
        $model = new InfoForm();
        if ($model->load(Yii::$app->request->post())) {
            $info =  $model->create();
            return $this->redirect(['view', 'id' => $info->id]);
        } else {
            $model->trigger = Info::TRIGGER_PAY;
            $model->msg_type = Info::MSG_EMAIL;
            return $this->render('create-info', [
                'model' => $model,
                'user' => $user,
            ]);
        }
    }

    /**
     * @name 触发条件
     */
    public function actionTrigger($id)
    {

        $info = $this->findModel($id);

        $goods = $info->goodsRels;

        $result = [];
        foreach ($goods as $k => $v) {
            $result[$v->res_name][] = $v;
        }
        
        $result['category'] = ArrayHelper::getColumn($result['category'], 'res_id');
        $result['goods'] = ArrayHelper::getColumn($result['goods'], 'res_id');

        $model = new Goods;

        $model->res_id = $result;



        return $this->render('trigger', [
                'model' => $model,
                'goods_info' => $result
            ]);
    }


    public function actionTri($info_id)
    {
        $req = Yii::$app->request->post();

        $name = $req['name'];
        $rid = $req['rid'];
        $checked = $req['checked'];

        $name = trim($name, '[]');


        if ($checked) {
            $m = new Goods;
            $m->info_id = $info_id;
            $m->res_name = $name;
            $m->res_id = $rid;
            if ($m->save()) {
                return $this->json();
            }
            
        } else {
            $m = Goods::find()->where(['info_id'=>$info_id, 'res_name'=>$name, 'res_id'=>$rid])->one();
            if ($m->delete()) {
                return $this->json();
            }
        }

        return $this->json(null, '配置出错', 0);

    }

    public function actionUpdateInfo($id)
    {

        $form = new InfoForm();
        $model = $this->findModel($id);

        $form->name = $model->name;
        $form->intro = $model->intro;
        $form->msg = $model->msg;
        $form->default = $model->default->user_id;
        $form->msg_time = $model->msg_time;
        $form->msg_type = explode(',', $model->msg_type);
        $form->trigger = $model->trigger;
        $selUsers = $model->users;

        $result = [];

        foreach ($selUsers as $k => $v) {
            $result[$v->user_id] = $v->user->username;
        }

        $form->user = array_keys($result);

        if ($form->load(Yii::$app->request->post())) {
            $info =  $form->update();

            return $this->redirect(['view', 'id' => $info->id]);
        } else {
            return $this->render('update-info', [
                'model' => $form,
                'sels' => $result
            ]);
        }
    }

    protected function findModel($id)
    {
        if (($model = Info::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    // public function actionIndex()
    // {
    //     $searchModel = new TaskSearch();
    //     $params = Yii::$app->request->queryParams;
    //     $params['TaskSearch']['res_name'] = 'common';
    //     $params['TaskSearch']['res_id'] = 0;

    //     $dataProvider = $searchModel->search($params);

    //     return $this->render('index', [
    //         'searchModel' => $searchModel,
    //         'dataProvider' => $dataProvider,
    //     ]);
    // }

    // /**
    //  * Displays a single Task model.
    //  * @param integer $id
    //  * @return mixed
    //  */
    // public function actionView($id)
    // {
    //     return $this->render('view', [
    //         'model' => $this->findModel($id),
    //     ]);
    // }

    // /**
    //  * Creates a new Task model.
    //  * If creation is successful, the browser will be redirected to the 'view' page.
    //  * @return mixed
    //  */
    // public function actionCreate()
    // {
    //     $model = new Task();

    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->id]);
    //     } else {
    //         $model->pre_finish = date('Y-m-d', strtotime('+2 day'));
    //         return $this->renderAjax('create', [
    //             'model' => $model,
    //         ]);
    //     }
    // }

    // /**
    //  * Updates an existing Task model.
    //  * If update is successful, the browser will be redirected to the 'view' page.
    //  * @param integer $id
    //  * @return mixed
    //  */
    // public function actionUpdate($id)
    // {
    //     $model = $this->findModel($id);

    //     if ($model->load(Yii::$app->request->post())) {

    //         $model->save();

    //         return $this->redirect(['view', 'id' => $model->id]);
    //     } else {

    //         $model->pre_finish = substr($model->pre_finish, 0,10);
    //         return $this->renderAjax('update', [
    //             'model' => $model,
    //         ]);
    //     }
    // }

    // /**
    //  * Deletes an existing Task model.
    //  * If deletion is successful, the browser will be redirected to the 'index' page.
    //  * @param integer $id
    //  * @return mixed
    //  */
    // public function actionDelete($id)
    // {
    //     $this->findModel($id)->del();

    //     return $this->redirect(['index']);
    // }

    // public function actionFinish($id)
    // {
    //     $model = $this->findModel($id);
    //     $model->finish();
    //     return $this->redirect(['index']);
    // }

}
