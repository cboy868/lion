<?php

namespace app\modules\grave\controllers\admin;

use app\modules\order\models\Order;
use app\modules\user\models\User;
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
use app\modules\shop\models\Goods;
use app\modules\grave\models\InsProcess;
use app\modules\grave\models\Bury;
use app\modules\grave\models\CarRecord;
use yii\web\NotFoundHttpException;

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

        return $portrait->saveAttach($info);
    }

    /**
     * Lists all Customer models.
     * @return mixed
     * @name 业务流程
     */
    public function actionIndex($step, $tomb_id)
    {
        if ($step > 5) {
            $step = 5;
        }
        $this->layout = '@app/modules/grave/views/admin/process/layout';
    	$method = Process::$step[$step]['method'];
        // Process::$tomb_id = $tomb_id;
    	return $this->$method();
    }

    protected function customer()
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
            $outerTransaction = Yii::$app->db->beginTransaction();
            try {
                $u = $req->post('User');
                $cu = $req->post('Customer');

                if (isset($u['id']) && !empty($u['id'])) {
                    $user = User::findOne($u['id']);
                }
                if (isset($cu['id']) && !empty($cu['id'])) {
                    $customer = Customer::findOne($cu['id']);
                }

                $user->load($req->post());
                $customer->load($req->post());
                $tomb->load($req->post());

                if ($user->validate()) {
//                    $user->mobile = $customer->mobile; 遇到重复手机号  可能会有问题 暂时去掉
                    if ($user->isNewRecord) {
                        $user->createUser();
                    }
                } else {
                    goto show;
                }
                $customer->user_id = $user->id;
                $customer->tomb_id = $tomb->id;

                if ($customer->validate()) {
                    $customer->save();
                } else {
                    goto show;
                }

                $tomb->user_id = $user->id;
                $tomb->customer_id = $customer->id;

                if ($tomb->validate()) {
                    //如果墓位还没预定，则预定
                    if ($tomb->status == Tomb::STATUS_EMPTY) {
                        $tomb->status = Tomb::STATUS_PRE;
                    }
                    $tomb->save();
                } else {
                    goto show;
                }

                if (in_array($tomb->status, [Tomb::STATUS_EMPTY, Tomb::STATUS_PRE])) {
                    Process::orderTomb();
                } 

                $outerTransaction->commit();
                return $this->next();
            } catch (\Exception $e) {
                echo $e->getMessage();
                Yii::error($e->getMessage(), __METHOD__);
                $outerTransaction->rollBack();
            }
        }


        show:
        // $agent = Yii::$app->controller->module->params['role']['agent'];
        $guide = Yii::$app->controller->module->params['role']['guide'];
        $agent = \app\modules\user\models\User::agents();
        $agents = ArrayHelper::map($agent, 'id', 'username');

        $tpl = $customer->isNewRecord ? 'customer' : 'customer_edit' ;


        return $this->render($tpl,[
                'model'=> $customer,
                'tomb' => $tomb,
                'user' => $user,
                'agent' => $agents,
                'guide' => Process::getRoleUsers($guide),
                'get' => Yii::$app->request->get(),
                'order' => Process::getOrder()
            ]);
    }

    protected function dead()
    {

        $customer = Process::customer();
        if (!$customer->id) {
            Yii::$app->session->setFlash('error', '请先填写客户信息');
            return $this->pre();
        }

        $session = Yii::$app->session;
        $key = 'dead.num' . Process::$tomb_id;
        if ($session->has($key)) {
            Process::$dead_model_num = $session->get($key);
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

                   $flag = false;
                   foreach ($models as $model) {
                        if (!$model->is_alive) {
                            $model->is_ins = Dead::INS_YES;
                        } else {
                            $model->pre_bury = null;
                            //如果修改 那是不是原来的预葬和派车都要删除? 手动删除可能更保险
                        }

                        if ($model->is_ins == Dead::INS_YES) {
                            $flag = true;
                        }

                        $model->save();

                       if ($post['is_memorial']) {
                           $memorial = Process::createMemorial();
                           $model->memorial_id = $memorial->id;
                           $model->save();
                       }
                    }

                    $outerTransaction->commit();

                    if (!$flag) {
                        return $this->next(4);
                    }
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


    protected function ins()
    {
        $tomb = Process::tomb();
        $model = Process::insPro();
        $deads = $model->deads();

        if (!$deads) {
            return $this->error('没有需要刻碑的使用人');
        }

        $ins_cfg = Yii::$app->controller->module->params['ins'];
        $fee = $ins_cfg['fee'];


        $req = Yii::$app->request;

        $type = $req->get('type') !== null ? $req->get('type') : $model->type;
//        $model->type = isset($type) ? $type : $model->type;


        $model->setScenario('handleIns');

        if ($model->load($req->post())) {

            $model->guide_id = $tomb->guide_id;
            $model->user_id = $tomb->user_id;


            $saveMethod = 'imgSave';
            if ($type == InsProcess::TYPE_FREE) {
                $saveMethod = 'freeSave';
            } else if ($type == InsProcess::TYPE_AUTO) {
                $saveMethod = 'autoSave';
            }

            if ($model->$saveMethod()) {

                $note = '大字%s小字%s刻字费%s颜料费%s繁体字费%s';

                $insData = [
                    'tid' => $model->tomb_id,
                    'price' => $model->letter_price + $model->paint_price + $model->tc_price,
                    'num' => $model->new_big_num + $model->new_small_num,
                    'note' => sprintf($note, $model->new_big_num, $model->new_small_num, $model->letter_price, $model->paint_price, $model->tc_price),
                    'use_time' =>$model->pre_finish,
                    'type' => 5
                ];

                $goods_id = $this->module->params['goods']['id']['insword'];
                $goods = Goods::findOne($goods_id);

                $goods->order($model->user_id, $insData);

                return $this->next();
            }

        }

        $cases = $model->getInsCfgCases($model->shape);

        if (!$cases) {
            $model->type = InsProcess::TYPE_IMG;
        }

        $model->pre_finish = $model->pre_finish == null ? '' : $model->pre_finish;

        $ins_data = [
            'model' => $model,
            'imgs'  => $model->img ? json_decode($model->img) : '',
            'get' => Yii::$app->request->get(),
            'paint' => $ins_cfg['paint'],
            'pos' => $ins_cfg['position'],
            'order' => Process::getOrder(),
            'goods' => $model->getGoodsInfo(),
            'fee' => $fee
        ];

        if ($type == InsProcess::TYPE_IMG) {
            return $this->render('ins-img',$ins_data);
        } else if ($type == InsProcess::TYPE_AUTO){
            $ins_info = $model->insInfo();

            return $this->render('ins-auto',array_merge($ins_data, [
                'back_word' => $ins_cfg['back_word'],
                'ins_info' => $ins_info,
                'dead_list' => $model->deads(),
                'cases' => $cases,
                'is_god' => false,
            ]));
        } else {
            $ins_info = $model->insInfo();

            return $this->render('ins-free',array_merge($ins_data, [
                'back_word' => $ins_cfg['back_word'],
                'ins_info' => $ins_info,
                'dead_list' => $model->deads(),
                'cases' => $cases,
                'is_god' => false,
            ]));
        }
    }

    protected function ins1()
    {
        $dead = Process::dead();

        if (count($dead) == 0) {
            Yii::$app->session->setFlash('error', '请先填写使用人信息');
            return $this->pre(2);
        }

        $model = Process::insProcess();
        $model->type = 1;

        $tomb = Process::tomb();

        $req = Yii::$app->request;
        if ($req->isPost) {


            if ($model->load($req->post())) {

                $model->guide_id = $tomb->guide_id;
                $model->user_id = $tomb->user_id;

                $method = $req->post('type') == 1 ? 'autoSave' : 'imgSave';

                // if ($req->post('type') == 1) {
                //     $model->autoSave();
                // } elseif ($req->post('type') == 3) {
                //     $model->imgSave();
                // }

                $pdata = $req->post('InsProcess');
                $big_new = $pdata['big_new'];
                $small_new = $pdata['small_new'];

                $model->new_font_num = json_encode(['big'=>$big_new, 'small'=>$small_new]);

                if ($model->$method()) {

                    $note = '大字%s小字%s刻字费%s颜料费%s繁体字费%s';

                    $insData = [
                        'price' => $model->letter_price + $model->paint_price + $model->tc_price,
                        'num' => $model->big_new + $model->small_new - $model->font_num,
                        'note' => sprintf($note, $model->big_new, $model->small_new, $model->letter_price, $model->paint_price, $model->tc_price)
                    ];

                    $goods_id = $this->module->params['goods']['id']['insword'];
                    $goods = Goods::findOne($goods_id);
                    $goods->order($model->user_id, $insData);

                    return $this->next();
                }
            }
        }

        $cases = $model->getInsCfgCases();

        if (!$cases) {
            $model->type = InsProcess::TYPE_IMG;
        }

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
            'goods' => $model->getGoodsInfo(),
            'is_god' => false,
        ]);
    }


    /**
     * @return array
     * @name 添加使用人
     */
    public function actionAddDead()
    {

        $this->dealDeadNum(true);
        return $this->json();

    }

    /**
     * @return array
     * @name 删除使用人
     */
    public function actionDelDead()
    {
        $dead_id = Yii::$app->request->get('dead_id');

        if ($dead_id) {
            Process::delDead($dead_id);
        }

        $this->dealDeadNum(false);

        return $this->json();
    }

    protected function dealDeadNum($plus=true)
    {
        $session = Yii::$app->session;
        $key = 'dead.num' . Process::$tomb_id;
        if ($session->has($key)) {
            if ($plus) {
                $num = $session->get($key)+1;
                $session->set($key, $num);
            } else if($session->get($key) > 1){
                $num = $session->get($key)-1;
                $session->set($key, $num);
            }

        } else {
            $pu = $plus ? 1:-1;
            $ori_num = Process::getDeadNum();
            $ori_num = $ori_num == 0 ? 2 : $ori_num;
            $session->set($key, $ori_num+$pu);
        }
        
    }

    protected function portrait()
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
                $outerTransaction = Yii::$app->db->beginTransaction();
                try {


                   foreach ($models as $model) {
                        $model->dead_ids = trim(implode($model->dead_ids, ','), ',');
                        $model->save();
                    }
                    $outerTransaction->commit();

                } catch (\Exception $e) {
                    echo $e->getMessage();
                    $outerTransaction->rollBack();
                }

                if (!Dead::hasUnPreBury(Process::$tomb_id)) {
                    return $this->end();
                }

                return $this->next();
            }
        }


        $d_sel = [];
        foreach ($dead as $k => $v) {
            $d_sel[$v['id']] = $v['dead_name'];
        }

    	return $this->render('portrait',[
            'models' => $models,
            'get' => Yii::$app->request->get(),
            'order' => Process::getOrder(),
            'dead' => $d_sel
            ]);
    }

    protected function bury()
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
            try {
                $outerTransaction = Yii::$app->db->beginTransaction(); 
                if ($model->load($req->post())) {

                    $dead_ids = $model->dead_id;
                    $dead_name = '';
                    foreach ($dead_ids as $k => $id) {
                        $dead_name .= $deads[$id]['dead_name'] . ',';
                        $deads[$id]->pre_bury = $model->pre_bury_date;
                        $deads[$id]->save();
                    }

                    $dead_id = implode($dead_ids, ',');
                    $dead_id = trim($dead_id, ',');

                    $model->dead_id = $dead_id;
                    $model->dead_name = trim($dead_name, ',');
                    $model->dead_num = count($dead_ids);
                    $model->bury_type = $model->generalType();

                    $model->bury_time = date('H:i:s', strtotime($model->pre_bury_date));

                    $model->save();


                    $extData = [
                        'tid' => $model->tomb_id,
                        'type' => Order::TYPE_BURY,
                        'use_time' => $model->pre_bury_date
                    ];

                    $goods_id = $this->module->params['goods']['id']['bury'];
                    $goods = Goods::findOne($goods_id);

                    $goods->order($model->user_id, $extData);


                    if ($car_model->load($req->post()) && $car_model->car_type != 3) {
                        $car_model->bury_id = $model->id;
                        $start_time = $model->pre_bury_date;

                        $car_model->use_date = substr($start_time, 0,10);
                        $car_model->use_time = trim(substr($start_time, 10));
                        $car_model->end_time = date('H:i', strtotime('+'.$car_model->address->time.' minute',strtotime($start_time)));
                        $car_model->save();
                    }
                }
                $outerTransaction->commit();

                return $this->next();
            } catch (\Exception $e) {
                Yii::error($e->getMessage(), __METHOD__);
                $outerTransaction->rollBack();
            }
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

        $customer = Process::customer();

        $nRecord = $carRecord['model'];
        $nRecord->loadDefaultValues();

    	return $this->render('bury', [
            'pres' => $burys['pre'],
            'bury' => $burys['bury'],
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

    /**
     * @name 删除预葬记录
     */
    public function actionDelBury($id)
    {
        $model = Bury::findOne($id);
        $carRecord = CarRecord::find()->where(['bury_id'=>$id])->one();

        $dead_ids = explode(',', $model->dead_id);
        $deads = Dead::find()->where(['id'=>$dead_ids])->all();

        foreach ($deads as $dead) {
            $dead->pre_bury = Process::DT_NULL;
            $dead->save();
        }

        if ($model->del() ) {
            if ($carRecord) {
                $carRecord->del();
            }
            return $this->json();
        }

        return $this->json(null, '预葬记录删除失败', 0);
    }


    protected function order()
    {
    	return $this->render('order');
    }

    protected function next($nstep = null)
    {
        $steps = Process::$step;

        $req = Yii::$app->request;
        $tomb_id = $req->get('tomb_id');
        $step = $req->get('step');

        if ($nstep) {
            return $this->redirect(['index', 'step'=>$nstep, 'tomb_id'=>$tomb_id]);
        }

        $nst = $step+1;

        if (isset($steps[$nst])) {
            return $this->redirect(['index', 'step'=>$nst, 'tomb_id'=>$tomb_id]);
        }

        return $this->end();
    }

    protected function pre($pstep = null)
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

    protected function end()
    {
        $order = Process::getOrder();
        return $this->redirect(['/order/admin/default/view', 'id'=>$order->id]);
    }
  
}
