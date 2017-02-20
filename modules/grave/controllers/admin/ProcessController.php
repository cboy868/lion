<?php

namespace app\modules\grave\controllers\admin;

use Yii;
use app\core\web\BackController;
use app\modules\grave\models\Process;
use yii\base\Model;
use app\modules\grave\models\Tomb;
use app\core\widgets\ActiveForm;

use app\core\helpers\ArrayHelper;

use app\modules\grave\models\Customer;
use app\modules\grave\models\Portrait;
use app\modules\grave\models\CarAddr;
// use app\modules\grave\models\Tomb;
use app\modules\grave\models\Dead;
// use app\modules\grave\models\Ins;
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
            'ue-upload' => [
                'class' => 'app\core\widgets\Ueditor\UploadAction',
            ],
            // 'web-upload' => [
            //     'class' => 'app\core\web\WebuploadAction',
            // ],

        ];
    }

    public function saveAttach($info)
    {
        $portrait = Portrait::findOne($info['res_id']);

        if (!$portrait) {
            return null;
        }

        $portrait->photo_original = $info['mid'];


        return $portrait->save();
    }

    /**
     * Lists all Customer models.
     * @return mixed
     */
    public function actionIndex($step, $tomb_id)
    {
        $this->layout = '@app/modules/grave/views/admin/process/layout';
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

        //不知道为啥 ajaxvalidate 不起作用
        // if ($req->isAjax && $user->load($req->post())) {
        //     Yii::$app->response->format = Response::FORMAT_JSON;
        //     return ActiveForm::validate($user);
        // }

        if ($req->isPost) {
            
            try {
                $outerTransaction = Yii::$app->db->beginTransaction();

                $user->load($req->post());
                $customer->load($req->post());
                $tomb->load($req->post());

                if ($user->validate()) {
                    $user->createUser();
                }

                $customer->user_id = $user->id;
                $customer->tomb_id = $tomb->id;
                if ($customer->validate()) {
                    $customer->save();
                }

                $tomb->user_id = $user->id;
                $tomb->customer_id = $customer->id;

                if ($tomb->validate()) {
                    //如果墓位还没预定，则预定
                    if ($tomb->status == Tomb::STATUS_EMPTY) {
                        $tomb->status = Tomb::STATUS_PRE;
                    }
                    $tomb->save();
                }

                if (in_array($tomb->status, [Tomb::STATUS_EMPTY, Tomb::STATUS_PRE])) {
                    Process::orderTomb();
                } 

                $outerTransaction->commit();
                return $this->next();
                
            } catch (\Exception $e) {
                echo $e->getMessage();
                $outerTransaction->rollBack();
            }
        }


        $agent = Yii::$app->controller->module->params['role']['agent'];
        $guide = Yii::$app->controller->module->params['role']['guide'];


    	return $this->render('customer',[
                'model'=> $customer,
                'tomb' => $tomb,
                'user' => $user,
                'agent' => Process::getRoleUsers($agent),
                'guide' => Process::getRoleUsers($guide),
                'get' => Yii::$app->request->get(),
                'order' => Process::getOrder()
            ]);
    }

    public function dead()
    {
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
        $tomb = Process::tomb();

        if (Yii::$app->request->isPost) {

            $post = Yii::$app->request->post();
            if ($tomb->load($post)) {
                $tomb->save();
            }


            if (Model::loadMultiple($models, $post) && Model::validateMultiple($models)) {
                try {
                   $outerTransaction = Yii::$app->db->beginTransaction(); 

                   foreach ($models as $model) {
                        if (!$model->is_alive) {
                            $model->is_ins = Dead::INS_YES;
                        }
                        $model->save();
                    }

                    if ($post['is_memorial']) {
                        Process::createMemorial();
                    }

                    $outerTransaction->commit();

                    return $this->next();

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
                'get' => Yii::$app->request->get(),
                'order' => Process::getOrder(),
                'tomb' => $tomb,
                'mnt_by' => $this->module->params['ins']['mnt_by'],
            ]);
    }

    // public function ins()
    // {

    //     $dead = Process::dead();


    //     if (count($dead) == 0) {
    //         Yii::$app->session->setFlash('error', '请先填写使用人信息');
    //         return $this->pre(2);
    //     }

    //     $model = Process::ins();
    //     $tomb = Process::tomb();

    //     $req = Yii::$app->request;
    //     if ($req->isPost) {
    //         if ($model->load($req->post())) {
    //             $model->img = json_encode($model->img);
    //             $model->guide_id = $tomb->guide_id;
    //             $model->user_id = $tomb->user_id;
    //             if ($model->save()) {
    //                 return $this->next();
    //             }
    //         }
    //     }

    //     return $this->render('ins', [
    //         'model' => $model,
    //         'imgs'  => json_decode($model->img),
    //         'pos' => Yii::$app->controller->module->params['ins']['position'],
    //         'get' => Yii::$app->request->get()
    //     ]);
    // }

    public function ins()
    {
        $dead = Process::dead();


        if (count($dead) == 0) {
            Yii::$app->session->setFlash('error', '请先填写使用人信息');
            return $this->pre(2);
        }

        $model = Process::insProcess();
        $model->type=1;


        $tomb = Process::tomb();

        $req = Yii::$app->request;
        if ($req->isPost) {

            $model->autoSave();

            if ($model->load($req->post())) {

                $model->img = json_encode($model->img);
                $model->guide_id = $tomb->guide_id;
                $model->user_id = $tomb->user_id;

                if ($model->save()) {
                    return $this->next();
                }
            }
        }

        $cases = $model->getInsCfgCases();
        $back_word = Yii::$app->controller->module->params['ins']['back_word'];
        $paint = Yii::$app->controller->module->params['ins']['paint'];

        $ins_info = $model->getInsInfo();


        //取碑的产品信息

        return $this->render('ins-auto', [
            'model' => $model,
            'imgs'  => $model->img ? json_decode($model->img) : '',
            'pos' => Yii::$app->controller->module->params['ins']['position'],
            'get' => Yii::$app->request->get(),
            'cases' => $cases,
            'back_word' => $back_word,
            'paint' => $paint,
            'front' => $ins_info['front'],
            'back' => $ins_info['back'],
            'dead_list' => $model->getDead(),
            'order' => Process::getOrder(),
            'goods' => $model->getGoodsInfo()
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
            $pu = $plus ? 1:-1;
            $session->set('dead.num', $ori_num+$pu);
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
            $post = $req->post();

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




                if (!Dead::hasUnPreBury(Process::$tomb_id)) {
                    return $this->next(6);
                }

                return $this->next();
            }

        }

    	return $this->render('portrait',[
            'models' => $models,
            'get' => Yii::$app->request->get(),
            'order' => Process::getOrder()
            ]);
    }

    public function bury()
    {

        $dead = Process::dead();
        if (count($dead) == 0) {
            Yii::$app->session->setFlash('error', '请先填写使用人信息');
            return $this->pre(2);
        }


        $burys = Process::burys();
        $model = $burys['model'];

        $deads = Process::dead();
        $carRecord = Process::carRecord();
        $car_model = $carRecord['model'];


        $req = Yii::$app->request;
        if ($req->isPost) {


            // p($req->post());die;


            if ($model->load($req->post())) {

                $dead_ids = $model->dead_id;
                $dead_name = '';
                foreach ($dead_ids as $k => $id) {
                    $dead_name .= $deads[$id]['dead_name'] . ',';
                }

                $dead_id = implode($dead_ids, ',');
                $dead_id = trim($dead_id, ',');

                $model->dead_id = $dead_id;
                $model->dead_name = trim($dead_name, ',');
                $model->dead_num = count($dead_ids);

                $model->save();
            }

            if ($car_model->load($req->post())) {
                $car_model->bury_id = $model->id;
                $car_model->save();
            }


            return $this->next();
        }


        //取待安葬的逝者
        $unpre = [];
        foreach ($deads as $dead) {
            if (!$dead->isPre && !$dead->is_alive) {
                array_push($unpre, $dead);
            }
        }


        $car_type = $this->module->params['car']['type'];
        $car_addr = CarAddr::find()->where(['status'=>CarAddr::STATUS_NORMAL])->all();

        $carAddr = [];
        foreach ($car_addr as $k => $v) {
            $carAddr[$v->id] = $v->title .':用时'. $v->time . '分';
        }


        $car_addr = ArrayHelper::map($car_addr, 'id', 'title');

        $customer = Process::customer();

        $nRecord = $carRecord['model'];
        $nRecord->loadDefaultValues();

    	return $this->render('bury', [
            'pres' => $burys['bury'],
            'model'=>$burys['model'],
            'get' => Yii::$app->request->get(),
            'order' => Process::getOrder(),
            'unpre' => $unpre,
            'car_type' => ArrayHelper::getColumn($car_type, 'name'),
            'car_addr' => $carAddr,
            'records' => ArrayHelper::index($carRecord['records'], 'bury_id'),
            'nRecord' => $carRecord['model'],
            'customer' => $customer

        ]);
    }

    public function order()
    {
    	return $this->render('order');
    }

    private function next($nstep = null)
    {
        $steps = Process::$step;

        $req = Yii::$app->request;
        $tomb_id = $req->get('tomb_id');
        $step = $req->get('step');

        if ($nstep) {
            return $this->redirect(['index', 'step'=>$nstep, 'tomb_id'=>$tomb_id]);
        }

        if (isset($steps[$step + 1])) {
            return $this->redirect(['index', 'step'=>$step+1, 'tomb_id'=>$tomb_id]);
        }

        return $this->end();
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

    private function end()
    {
        $order = Process::getOrder();
        return $this->redirect(['/order/admin/default/view', 'id'=>$order->id]);
    }
  
}
