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

/**
 * CustomerController implements the CRUD actions for Customer model.
 */
class ProController extends BackController
{

    public function init()
    {
        Process::$tomb_id = Yii::$app->request->get('tomb_id');
        parent::init();
    }



    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCustomer()
    {
        $req = Yii::$app->request;


        if ($req->isPost) {

            $tomb = Process::tomb();
            $user = Process::user();
            $customer = Process::customer();
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

                    return $this->json($user->getErrors(), '数据保存失败', 0);
                }
                $customer->user_id = $user->id;
                $customer->tomb_id = $tomb->id;

                if ($customer->validate()) {
                    $customer->save();
                } else {
                    return $this->json($customer->getErrors(), '数据保存失败', 0);
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
                    return $this->json($tomb->getErrors(), '数据保存失败', 0);
                }

                if (in_array($tomb->status, [Tomb::STATUS_EMPTY, Tomb::STATUS_PRE])) {
                    Process::orderTomb();
                }

                $outerTransaction->commit();
            } catch (\Exception $e) {
                echo $e->getMessage();
                Yii::error($e->getMessage(), __METHOD__);
                $outerTransaction->rollBack();
            }
        }

        return $this->json();
    }

  
}
