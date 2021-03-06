<?php

namespace app\modules\grave\models;

use Yii;
use app\core\helpers\ArrayHelper;
use app\modules\grave\models\Customer;
use app\modules\grave\models\Tomb;
use app\modules\grave\models\Dead;
use app\modules\grave\models\Ins;
use app\modules\grave\models\Portrait;
use app\modules\grave\models\Bury;
use app\modules\user\models\User;
use app\modules\grave\models\InsProcess;
use app\modules\grave\models\CarRecord;
use app\modules\memorial\models\Memorial;
use yii\web\NotFoundHttpException;
/**
 * This is the model class for table "{{%grave_portrait}}".
 *
 * @property integer $id
 * @property integer $guide_id
 * @property integer $user_id
 * @property integer $tomb_id
 * @property string $title
 * @property integer $goods_id
 * @property integer $order_id
 * @property integer $order_rel_id
 * @property string $dead_ids
 * @property string $photo_original
 * @property string $photo_processed
 * @property integer $confrim_by
 * @property string $confirm_at
 * @property string $photo_confirm
 * @property string $use_at
 * @property string $up_at
 * @property integer $notice_id
 * @property integer $type
 * @property string $note
 * @property integer $status
 * @property integer $updated_at
 * @property integer $created_at
 */
class Process extends \yii\base\Model
{

//    const DT_NULL = '0000-00-00 00:00:00';
    const DT_NULL = null;
    const D_NULL  = '0000-00-00';

    public static $tomb_id;

    public static $dead_model_num = 0;

//    public static $step = [
//        1 => ['method' => 'customer','title'=>'办理人信息'],
//        2 => ['method' => 'dead','title'=>'使用人信息'],
//        3 => ['method' => 'ins','title'=>'碑文信息'],
//        4 => ['method' => 'portrait','title'=>'瓷像信息'],
//        5 => ['method' => 'bury','title'=>'安葬'],
//        6 => ['method' => 'mall','title'=>'购买商品'],
//        // 6 => ['method' => 'order','title'=>'订单'],
//    ];

    public static $step = [
        1 => ['method' => 'customer','title'=>'办理人信息'],
        2 => ['method' => 'dead','title'=>'使用人信息'],
        3 => ['method' => 'bury','title'=>'安葬'],
        4 => ['method' => 'ins','title'=>'碑文信息'],
        5 => ['method' => 'portrait','title'=>'瓷像信息'],
        6 => ['method' => 'mall','title'=>'购买商品'],
        // 6 => ['method' => 'order','title'=>'订单'],
    ];


    // public function __construct($config = [], $tomb_id)
    // {
    //     parent::__construct($config = []);

    //     $this->tomb_id = $tomb_id;
    // }

    public static function tomb()
    {
        if (($model = Tomb::findOne(self::$tomb_id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public static function customer()
    {
        $tomb = self::tomb(self::$tomb_id);

        if ($tomb->customer_id) {
            $customer = Customer::findOne($tomb->customer_id);
            if ($customer) {
                return $customer;
            }
        }
        return new Customer();
    }

    public static function dead()
    {
        $deads = Dead::find()->where(['tomb_id'=>self::$tomb_id])
                         ->andWhere(['status'=>Dead::STATUS_NORMAL])
                         ->indexBy('id')
                         ->orderBy('sort asc')
                         ->all();

        if (self::getDeadNum() == 0 && self::$dead_model_num == 0) {
            self::$dead_model_num = 2;
        }
        

        if ((self::$dead_model_num - self::getDeadNum()) > 0) {
            $new = self::$dead_model_num - self::getDeadNum();

            for ($i=0; $i < $new; $i++) { 
                $newDead = new Dead();
                $newDead->tomb_id = self::$tomb_id;
                $newDead->user_id = self::tomb()->user_id;

                $deads[] = $newDead;
            }
        }

        return $deads;
    }

    public static function bury($bury_id)
    {
        return Bury::findOne($bury_id);
    }

    public static function burys()
    {
        $bury = Bury::find()->where(['tomb_id'=>self::$tomb_id])
                         ->andWhere(['status'=>Bury::STATUS_OK])
                         ->all();

        $pre = Bury::find()->where(['tomb_id'=>self::$tomb_id])
                            ->andWhere(['status'=>Bury::STATUS_NORMAL])
                            ->all();

        $model = new Bury();
        $tomb = self::tomb();
        $model->tomb_id = self::$tomb_id;
        $model->user_id = $tomb->user_id;

        return ['bury'=>$bury,'pre'=>$pre, 'model'=>$model];
    }

    // public static function preBury()
    // {
    //     $model = new Bury();
    //     $tomb = self::tomb();
    //     $model->tomb_id = self::$tomb_id;
    //     $model->user_id = $tomb->user_id;
    //     return $model;
    // }

    public static function carRecord()
    {
        $records = CarRecord::find()->where(['tomb_id'=>self::$tomb_id])
                                    ->andWhere(['status'=>CarRecord::STATUS_NORMAL])
                                    ->all();


        $model = new CarRecord();
        $tomb = self::tomb();
        $model->tomb_id = self::$tomb_id;
        $model->user_id = $tomb->user_id;

        return ['records'=>$records, 'model'=>$model];
    }

    public static function getDeadNum() 
    {
        return Dead::find()->where(['tomb_id'=>self::$tomb_id])
                            ->andWhere(['status'=>Dead::STATUS_NORMAL])
                            ->count();

    }

    public static function delDead($dead_id)
    {
        $model = Dead::findOne($dead_id);
        $model->status = Dead::STATUS_DEL;

        return $model->save();
    }


    public static function newDead()
    {
        return new Dead();

    }

    public static function ins()
    {
        // $position = Yii::$app->controller->module->params['ins']['position'];

        $ins = Ins::find()->where(['tomb_id'=>self::$tomb_id])
                         ->andWhere(['status'=>Dead::STATUS_NORMAL])
                         // ->indexBy('position')
                         ->one();

        // foreach ($position as $k => $v) {
        //     if (!isset($ins[$k])) {
        //         $ins[$k] = new Ins();
        //         $ins[$k]->tomb_id = self::$tomb_id;
        //     }
        // }


        if (!$ins) {
            $ins = new Ins();
            $ins->tomb_id = self::$tomb_id;
        }

        return $ins;
    }


    public static function insPro()
    {
        $ins = InsPro::find()->where(['tomb_id'=>self::$tomb_id])
            ->andWhere(['status'=>Dead::STATUS_NORMAL])
            ->one();

        if (!$ins) {
            $ins = new InsPro();
            $ins->tomb_id = self::$tomb_id;
            $ins->type = InsPro::TYPE_AUTO;
        }

        return $ins;
    }



    public static function insProcess()
    {


        // $position = Yii::$app->controller->module->params['ins']['position'];

        $ins = InsProcess::find()->where(['tomb_id'=>self::$tomb_id])
                         ->andWhere(['status'=>Dead::STATUS_NORMAL])
                         // ->indexBy('position')
                         ->one();

        // foreach ($position as $k => $v) {
        //     if (!isset($ins[$k])) {
        //         $ins[$k] = new Ins();
        //         $ins[$k]->tomb_id = self::$tomb_id;
        //     }
        // }


        if (!$ins) {
            $ins = new InsProcess();
            $ins->tomb_id = self::$tomb_id;
        }

        return $ins;
    }

    public static function portrait()
    {
        $portraits = Portrait::find()->where(['tomb_id'=>self::$tomb_id])
                         ->andWhere(['<>', 'status', Portrait::STATUS_DEL])
                         ->all();
        return $portraits;

    }

    

    public static function user()
    {
        $tomb = self::tomb(self::$tomb_id);

        if ($tomb->user_id && ($user = User::findOne($tomb->user_id))) {
            return $user;
        }
        return new User();
    }

    public static function getRoleUsers($role_name)
    {

        $auth = Yii::$app->authManager;

        if (is_array($role_name)) {
            $users = [];
            foreach ($role_name as $k => $v) {
                $user_id = $auth->getUserIdsByRole($v);

                $tmp = User::find()->where(['id'=>$user_id])
                             ->andWhere(['status'=>User::STATUS_ACTIVE])
                             ->select(['id', 'username'])
                             ->asArray()
                             ->all();

                $users = array_merge($users, $tmp);
            }
        } else if (is_string($role_name)) {


            $user_id = $auth->getUserIdsByRole($role_name);

            $users = User::find()->where(['id'=>$user_id])
                             ->andWhere(['status'=>User::STATUS_ACTIVE])
                             ->select(['id', 'username'])
                             ->asArray()
                             ->all();

        }
        

        $users = ArrayHelper::map($users, 'id', 'username');
        return $users;
    }

    /**
     * @name 取墓位订单
     */
    public static function orderTomb()
    {
        $tomb = self::tomb();

        $order = Order::createTombOrder($tomb->user_id, $tomb);
        return $order;
    }

    public static function getOrder()
    {
        $tomb = self::tomb();
        if ($tomb->user_id) {
            return Order::getOriOrder($tomb->user_id, ['tid'=>$tomb->id]);
        }

        return null;
    }

    public static function createMemorial()
    {
        $tomb = self::tomb();
        $dead = self::dead();

        $title = '';
        foreach ($dead as $k => $v) {
            if (!$v->is_alive) {
                $title .= $v->dead_name . ',';
            }
        }
        $title = trim($title, ',');

        $memorial = Memorial::create($tomb->user_id, $title, $tomb->id);

        return $memorial;
    }


    /**
     * @name 获取最近一个预安葬记录的时间
     */
    public static function preBuryDate($time=false)
    {

        $pre_date = Bury::find()->where(['tomb_id'=>self::$tomb_id])
            ->andWhere(['status'=>Bury::STATUS_NORMAL])
            ->andWhere(['>', 'pre_bury_date', date('Y-m-d')])
            ->min('pre_bury_date');

        if ($time) {
            return $pre_date ? $pre_date : '';
        } else {
            return $pre_date ? substr($pre_date, 0, 10) : '';
        }

    }

    // public static function order()
    // {
    //     return Portrait::find()->where(['tomb_id'=>self::$tomb_id])
    //                      ->andWhere(['status'=>Dead::STATUS_NORMAL])
    //                      ->all();

    // }

}
