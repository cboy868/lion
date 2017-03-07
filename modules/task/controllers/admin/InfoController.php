<?php

namespace app\modules\task\controllers\admin;

use Yii;
use app\modules\task\models\Info;
use app\modules\task\models\InfoForm;
use app\modules\task\models\User;
use app\modules\task\models\Goods;

use app\modules\task\models\search\InfoSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\core\helpers\ArrayHelper;

/**
 * InfoController implements the CRUD actions for Info model.
 */
class InfoController extends BackController
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
     * Lists all Info models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InfoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Info model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Info model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new InfoForm();
        if ($model->load(Yii::$app->request->post())) {
            $info =  $model->create();
            return $this->redirect(['view', 'id' => $info->id]);
        } else {
            $model->trigger = Info::TRIGGER_PAY;
            $model->msg_type = Info::MSG_EMAIL;
            return $this->render('create', [
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



    /**
     * Updates an existing Info model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

        $form = new InfoForm();
        $model = $this->findModel($id);

        $form->name = $model->name;
        $form->intro = $model->intro;
        $form->msg = $model->msg;
        $form->default = $model->default->user_id;
        $selUsers = $model->users;

        $result = [];

        foreach ($selUsers as $k => $v) {
            $result[$v->user_id] = $v->user->username;
        }

        $form->user = array_keys($result);

        if ($form->load(Yii::$app->request->post())) {
            $info =  $model->create();

            return $this->redirect(['view', 'id' => $info->id]);
        } else {
            return $this->render('update', [
                'model' => $form,
                'sels' => $result
            ]);
        }
    }

    /**
     * Deletes an existing Info model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $connection = Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try {
            $this->findModel($id)->delete();
            $connection->createCommand()->delete(User::tableName(), ['info_id'=>$id])->execute();
            $transaction->commit();

        } catch (\Exception $e) {
            $transaction->rollBack();
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Info model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Info the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Info::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
