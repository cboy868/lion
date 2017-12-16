<?php
namespace app\modules\grave\widgets;

use yii;
use app\core\helpers\ArrayHelper;
use app\modules\grave\models\Tomb as TombModel;
use app\modules\grave\models\Customer;
use app\modules\grave\models\Ins;
use app\modules\order\models\Order;
use app\modules\grave\models\CarRecord;
use app\modules\grave\models\Bury;
use app\modules\order\models\Refund;
use app\modules\task\models\Task;
use app\modules\sys\models\Note;
use app\modules\grave\models\Process;
use app\modules\user\models\User;
use yii\base\Model;
use app\modules\grave\models\InsProcess;
/**
 * The ZActiveForm widget extend ActiveForm.
 *
 * @author wsq <cboy868@163.com>
 */
class Pro extends \yii\base\Widget
{

    public $tomb_id;

    public $tomb;
    
    public $method;

    protected $methods = array(
        'tomb',      //墓位详情
        'customer',  //客户信息
        'ins',       //碑文
        'portrait',  //瓷像
        'order',     //订单
        'dead',      //逝者
    );

    /**
     * Renders the widget.
     */
    public function run() {
      $this->tomb = TombModel::findOne($this->tomb_id);
      $method = $this->method;
      return $this->$method();
    }

    public function tomb()
    {
      return $this->render('pro/tomb', ['tomb'=>$this->tomb]);
    }

    protected function customer()
    {
        $customer = Process::customer();

        $tomb = Process::tomb();
        $user = Process::user();

        // $agent = Yii::$app->controller->module->params['role']['agent'];
        $guide = Yii::$app->controller->module->params['role']['guide'];
        $agent = \app\modules\user\models\User::agents();
        $agents = ArrayHelper::map($agent, 'id', 'username');


        $tpl = $customer->isNewRecord ? 'pro/customer' : 'pro/customer_edit' ;

        return $this->render($tpl, [
            'model'=> $customer,
            'tomb' => $tomb,
            'user' => $user,
            'agent' => $agents,
            'guide' => Process::getRoleUsers($guide),
            'get' => Yii::$app->request->get(),
        ]);
    }

    /**
     * @name 逝者
     */
    protected function dead()
    {
        $customer = Process::customer();


        $session = Yii::$app->session;
        $key = 'dead.num' . Process::$tomb_id;
        if ($session->has($key)) {
            Process::$dead_model_num = $session->get($key);
        }

        $models = Process::dead();
        $tomb = Process::tomb();

        // $model->loadDefaultValues();

        $dead_title = Yii::$app->controller->module->params['dead_title'];
        $dead_titles = [];
        foreach ($dead_title as $title) {
            $dead_titles[$title] = $title;
        }
        return $this->render('pro/dead',[
            'models' => Process::dead(),
            'dead_title' => $dead_titles,
            'bone_type' => Yii::$app->controller->module->params['bone_type'],
            'bone_box' => Yii::$app->controller->module->params['bone_box'],
            'get' => Yii::$app->request->get(),
            'order' => Process::getOrder(),
            'tomb' => $tomb,
            'mnt_by' => Yii::$app->getModule('grave')->params['ins']['mnt_by'],
        ]);
    }

    protected function ins()
    {

        $tomb = Process::tomb();



        $model = Process::insPro();
        $deads = $model->deads();




        $ins_cfg = Yii::$app->getModule('grave')->params['ins'];
        $fee = $ins_cfg['fee'];


        $req = Yii::$app->request;

        $type = $req->get('type') !== null ? $req->get('type') : $model->type;
//        $model->type = isset($type) ? $type : $model->type;


        $model->setScenario('handleIns');


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

        $ins_info = $model->insInfo();



        return $this->render('pro/ins-auto',array_merge($ins_data, [
            'back_word' => $ins_cfg['back_word'],
            'ins_info' => $ins_info,
            'dead_list' => $model->deads(),
            'cases' => $cases,
            'is_god' => false,
        ]));



    }

}