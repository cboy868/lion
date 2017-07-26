<?php

namespace app\modules\task\controllers\admin;

use app\modules\order\models\OrderRel;
use app\modules\task\models\ProForm;
use Yii;
use app\modules\task\models\Info;
use app\modules\task\models\InfoForm;
use app\modules\user\models\User;
use app\modules\task\models\User as TaskUser;
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
    public function actionIndex($pid=null)
    {

        $query = Info::find();
        if (!$pid) {
            $query->where(['<>', 'pid', 0]);
        } else {
            $query->where(['pid'=>$pid]);
        }

        $infos = $query->orderBy('pid asc')->all();

        return $this->render('index', [
            'info'  => $infos,
        ]);

    }


    /**
     * @name 项目管理
     */
    public function actionProject()
    {

//        $info = Info::findOne(14);
//        $order_rel = OrderRel::findOne(27);
//        $info->createTask($order_rel, 'goods', $order_rel->tid);

        $infos = Info::find()->where(['pid'=>0])->orderBy('code asc')->all();

        return $this->render('project', [
            'info'  => $infos,
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
        $request = Yii::$app->request;
        $model = new InfoForm();
        if ($model->load($request->post())) {

            $info =  $model->create();
            return $this->redirect(['index', 'pid' => $info->pid]);
        } else {
            $model->trigger = Info::TRIGGER_PAY;
            $model->msg_type = Info::MSG_EMAIL;

            $user = User::find()->where(['is_staff'=>User::STAFF_YES, 'status'=>User::STATUS_ACTIVE])->all();

            $model->pid = $request->get('pid') ? $request->get('pid') : 0;
            return $this->render('create', [
                'model' => $model,
                'user' => $user,
            ]);
        }
    }

    public function actionCreatePro()
    {
        $request = Yii::$app->request;
        $model = new ProForm();
        if ($model->load($request->post()) && $model->create()) {

            return $this->redirect(['project']);
        } else {
            $model->trigger = Info::TRIGGER_PAY;

            return $this->render('create-pro', [
                'model' => $model,
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
        $model = new Goods;


        if ($goods) {
            $result = [];
            foreach ($goods as $k => $v) {
                $result[$v->res_name][] = $v;
            }

            if (isset($result['category'])) {
                $result['category'] = ArrayHelper::getColumn($result['category'], 'res_id');
            }

            if (isset($result['goods'])) {
                $result['goods'] = ArrayHelper::getColumn($result['goods'], 'res_id');
            }
            
            $model->res_id = $result;

            return $this->render('trigger', [
                'model' => $model,
                'goods_info' => $result
            ]);
        }
        return $this->render('trigger', [
                'model' => $model,
            ]);
    }


    public function actionTri($info_id)
    {
        $req = Yii::$app->request->post();

        $name = $req['name'];
        $rid = $req['rid'];
        $checked = $req['checked'];

        // $name = trim($name, '[]');

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
        $form->msg_time = $model->msg_time;
        $form->msg_type = explode(',', $model->msg_type);
        $form->trigger = $model->trigger;
        $form->pid = $model->pid;
        $selUsers = $model->users;

        $result = [];

        foreach ($selUsers as $k => $v) {
            $result[$v->user_id] = $v->user->username;
        }

        $form->user = array_keys($result);

        if ($form->load(Yii::$app->request->post())) {
            $info =  $form->update();

            return $this->redirect(['index', 'pid' => $info->pid]);
        } else {
            return $this->render('update', [
                'model' => $form,
                'sels' => $result
            ]);
        }

    }

    public function actionUpdatePro($id)
    {

        $form = new ProForm();
        $model = $this->findModel($id);

        $form->name = $model->name;
        $form->intro = $model->intro;
        $form->trigger = $model->trigger;


        if ($form->load(Yii::$app->request->post()) && $form->update()) {
            return $this->redirect(['project']);
        } else {
            return $this->render('update-pro', [
                'model' => $form,
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
        $model = $this->findModel($id);

        $session = Yii::$app->session;


        $connection = Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try {
            $this->findModel($id)->delete();
            $connection->createCommand()->delete(TaskUser::tableName(), ['info_id'=>$id])->execute();
            $transaction->commit();
            $session->setFlash('success', '设置删除成功');

        } catch (\Exception $e) {
            $transaction->rollBack();
        }

        return $this->redirect(['index', 'pid'=>$model->pid]);
    }

    public function actionDeletePro($id)
    {
        $model = $this->findModel($id);

        $session = Yii::$app->session;
        if ($model->hasChild()) {
            $session->setFlash('error', '此项目下尚有任务设置，请先删除任务设置');
            return $this->redirect(['project']);
        }

        $this->findModel($id)->delete();

        return $this->redirect(['project']);
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
