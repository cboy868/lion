<?php

namespace app\modules\grave\controllers\admin;

use Yii;
use app\core\web\BackController;
use app\modules\grave\models\Process;
use yii\base\Model;
use app\modules\grave\models\Tomb;



use app\modules\grave\models\Customer;
// use app\modules\grave\models\Tomb;
// use app\modules\grave\models\Dead;
// use app\modules\grave\models\Ins;
// use app\modules\grave\models\Portrait;
// use app\modules\grave\models\Bury;
// use app\modules\user\models\User;
/**
 * CustomerController implements the CRUD actions for Customer model.
 */
class ProcessController extends BackController
{

    public function init()
    {
        Process::$tomb_id = Yii::$app->request->get('tomb_id');
        parent::init();
    }

    public function actions()
    {
        return [
            'pl-upload' => [
                'class' => 'app\core\web\PluploadAction',
            ],

        ];
    }

    /**
     * Lists all Customer models.
     * @return mixed
     */
    public function actionIndex($step, $tomb_id)
    {
        $this->layout = '@app/core/views/layouts/single';
    	$method = Process::$step[$step]['method'];
        // Process::$tomb_id = $tomb_id;
    	return $this->$method();
    }


    public function customer()
    {
        //todo 尚未预定的墓位，要提前预定

        $req = Yii::$app->request;

        $customer = Process::customer();
        $tomb = Process::tomb();
        $user = Process::user();


        if ($req->isPost) {
            var_dump($tomb->load(Yii::$app->request->post()));

            p(Yii::$app->request->post());
            p($tomb->getErrors());die;

            die;
        }


        if ($customer->load(Yii::$app->request->post()) && $tomb->load(Yii::$app->request->post()) && $user->load(Yii::$app->request->post())) {

            try {
                $outerTransaction = Yii::$app->db->beginTransaction();
                p($user);die;

                $user->createUser();



                $customer->user_id = $user->id;
                $customer->tomb_id = $tomb->id;
                $customer->save();

                $tomb->user_id = $user->id;
                $tomb->customer_id = $customer->id;
                //如果墓位还没预定，则预定
                if ($tomb->status == Tomb::STATUS_EMPTY) {
                    $tomb->status = Tomb::STATUS_PRE;
                }
                $tomb->save();

                $outerTransaction->commit();
            } catch (\Exception $e) {
                echo $e->getMessage();
                $outerTransaction->rollBack();
            }
            return $this->next();
        }

        $agent = Yii::$app->controller->module->params['role']['agent'];
        $guide = Yii::$app->controller->module->params['role']['guide'];


    	return $this->render('customer',[
                'model'=> $customer,
                'tomb' => $tomb,
                'user' => $user,
                'agent' => Process::getRoleUsers($agent),
                'guide' => Process::getRoleUsers($guide),
                'get' => Yii::$app->request->get()
            ]);
    }

    public function dead()
    {

        // echo Yii::$app->session->getFlash('error');die;

        $customer = Process::customer();
        if (!$customer->id) {
            Yii::$app->session->setFlash('error', '请先填写客户信息');
            return $this->pre();
        }

        $session = Yii::$app->session;

        if ($session->has('dead.num')) {
            Process::$dead_model_num = $session->get('dead.num');
        }

        $models = Process::dead();

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();

            foreach ($post['Dead'] as $k => &$v) {
                if ($v['dead_title'] == '其他') {
                    $v['dead_title'] = $post['dt'][$k];
                }
           }unset($v);
            if (Model::loadMultiple($models, $post) && Model::validateMultiple($models)) {
                try {
                   $outerTransaction = Yii::$app->db->beginTransaction(); 

                   foreach ($models as $model) {
                        $model->save();
                    }
                    $outerTransaction->commit();

                } catch (\Exception $e) {
                    echo $e->getMessage();
                    $outerTransaction->rollBack();
                }
            }
        }

        // $model->loadDefaultValues();

        $dead_title = Yii::$app->controller->module->params['dead_title'];
        $dead_titles = [];
        foreach ($dead_title as $title) {
            $dead_titles[$title] = $title;
        }
    	return $this->render('dead',[
                'models' => Process::dead(),
                'dead_title' => $dead_titles,
                'bone_type' => Yii::$app->controller->module->params['bone_type'],
                'bone_box' => Yii::$app->controller->module->params['bone_box'],
                'get' => Yii::$app->request->get()
            ]);
    }

    public function ins()
    {

        $dead = Process::dead();


        if (count($dead) == 0) {
            Yii::$app->session->setFlash('error', '请先填写使用人信息');
            return $this->pre(2);
        }

        $model = Process::ins();
        $tomb = Process::tomb();

        $req = Yii::$app->request;
        if ($req->isPost) {
            if ($model->load($req->post())) {
                $model->img = json_encode($model->img);
                $model->guide_id = $tomb->guide_id;
                $model->user_id = $tomb->user_id;
                if ($model->save()) {
                    return $this->next();
                }
            }
        }

        return $this->render('ins', [
            'model' => $model,
            'imgs'  => json_decode($model->img),
            'pos' => Yii::$app->controller->module->params['ins']['position'],
            'get' => Yii::$app->request->get()
        ]);
    }

    public function actionAddDead()
    {

        $this->dealDeadNum(true);
        return $this->json();

    }

    public function actionDelDead()
    {

        $dead_id = Yii::$app->request->get('dead_id');


        if ($dead_id) {
            Process::delDead($dead_id);
        }

        $this->dealDeadNum(false);

        return $this->json();
    }

    private function dealDeadNum($plus=true)
    {
        $session = Yii::$app->session;
        $ori_num = Process::getDeadNum();

        if ($session->has('dead.num')) {

            if ($plus) {
                $num = $session->get('dead.num')+1;
                $session->set('dead.num', $num);
            } else if($session->get('dead.num') > 1){
                $num = $session->get('dead.num')-1;
                $session->set('dead.num', $num);
            }

        } else {
            $session->set('dead.num', $ori_num);
        }
        
    }

    public function portrait()
    {
        $dead = Process::dead();
        if (count($dead) == 0) {
            Yii::$app->session->setFlash('error', '请先填写使用人信息');
            return $this->pre(2);
        }

        $models = Process::portrait();

        $req = Yii::$app->request;
        if ($req->isPost) {
            return $this->next();
        }

    	return $this->render('portrait',[
            'models' => $models,
            'get' => Yii::$app->request->get()
            ]);
    }

    public function bury()
    {

        $dead = Process::dead();
        if (count($dead) == 0) {
            Yii::$app->session->setFlash('error', '请先填写使用人信息');
            return $this->pre(2);
        }


        $models = Process::bury();

        $req = Yii::$app->request;
        if ($req->isPost) {
            return $this->next();
        }
        
    	return $this->render('bury', [
            'models' => $models,
            'get' => Yii::$app->request->get()
        ]);
    }

    public function order()
    {
    	return $this->render('order');
    }

    private function next()
    {
        $steps = Process::$step;

        $req = Yii::$app->request;
        $tomb_id = $req->get('tomb_id');
        $step = $req->get('step');

        if (isset($steps[$step + 1])) {
            return $this->redirect(['index', 'step'=>$step+1, 'tomb_id'=>$tomb_id]);
        }
    }

    private function pre($pstep = null)
    {
        $steps = Process::$step;

        $req = Yii::$app->request;
        $tomb_id = $req->get('tomb_id');
        $step = $req->get('step');

        if ($pstep) {
            return $this->redirect(['index', 'step'=>$pstep, 'tomb_id'=>$tomb_id]);
        }

        if (isset($steps[$step - 1])) {
            return $this->redirect(['index', 'step'=>$step-1, 'tomb_id'=>$tomb_id]);
        }
    }
  
}
