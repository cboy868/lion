<?php

namespace app\modules\admin\models;

use app\core\helpers\StringHelper;
use app\modules\grave\models\Customer;
use app\modules\grave\models\Dead;
use app\modules\grave\models\Grave;
use app\modules\grave\models\OrderRel;
use app\modules\grave\models\Tomb;
use app\modules\order\models\Order;
//use app\modules\order\models\OrderRel;
use app\modules\order\models\Pay;
use app\modules\order\models\Refund;
use app\modules\user\models\User;
use yii\web\NotFoundHttpException;
/**
 * Created by PhpStorm.
 * User: wansq
 * Date: 2017/9/26
 * Time: 17:38
 *
 */

/**
 * Class Pdf
 * pdf 打印数据获取类
 * A4纸宽度大概在 210x297左右
 */
class Pdf extends \yii\base\Model
{
    public $tomb_id;

    public $order_id;

    public $pay_id;

    public $refund_id;

    public $pay;

    public $tomb;

    public $order;

    public $refund;



    public static $field_map = [
        'username'             => '购墓人',
        'grave'            => '墓区',
        'tomb_no'          => '墓位号',
        'row'              => '排号',
        'col'              => '列号',
        'tomb_price'       => '墓价',
        'total'            => '订单总额',
        'guide_name'       => '导购员',
        'this_pay'            => '本次付款',
        'this_payment'          => '本次付款（大写）',
        'refund_price'     => '退款金额',
        'refund_price_rmb' => '退款金额（大写）',
        'already_pay'     => '已付款',
        'already_pay_rmb' => '已付款',
        'should_pay'      => '应付款',
        'should_pay_rmb'  => '应付款',
        'time'             => '收款日期',
        'note'             => '备注',
        'op_name'          => '操作员',




        'burial'           => '安葬费',
        'expand'           => '扩穴费',
        'ins'              => '碑文费用',
        'second_burial'    => '合葬费',//第二次安葬是合葬费
        'smallware'        => '小商品费用',
    ];




    public function init()
    {
        if ($this->tomb_id) {
            $this->tomb = Tomb::findOne($this->tomb_id);
            if (!$this->tomb) {
                return new NotFoundHttpException('The requested pay does not exist');
            }
        }

        if ($this->order_id) {
            $this->order = Order::findOne($this->order_id);
            if (!$this->order) {
                return new NotFoundHttpException('The requested pay does not exist');
            }

            if (!$this->tomb && $this->order->tid) {
                $this->tomb = Tomb::findOne($this->order->tid);
                if (!$this->tomb) {
                    return new NotFoundHttpException('The requested pay does not exist');
                }
            }
        }


        if ($this->pay_id) {
            $this->pay = Pay::findOne($this->pay_id);

            if (!$this->pay) {
                return new NotFoundHttpException('The requested pay does not exist');
            }

            if (!$this->order) {
                $this->order = $this->pay->order;
            }



            if (!$this->tomb && $this->order->tid) {
                $this->tomb = Tomb::findOne($this->order->tid);
                if (!$this->tomb) {
                    return new NotFoundHttpException('The requested pay does not exist');
                }
            }
        }

        if ($this->refund_id){
            $this->refund = Refund::findOne($this->refund_id);
        }

        parent::init();
    }

    public static function fieldMap()
    {
        return self::$field_map;
    }

    public function getOpName($type='order')
    {
        if ($type=='order') {
            $user = User::findOne($this->order->op_id);
            return $user->username;
        }

        return '';
    }

    public function getTombNo()
    {
        return $this->tomb->tomb_no;
    }

    public function getCol()
    {
        return $this->tomb->col;
    }

    public function getRow()
    {
        return $this->tomb->row;
    }

    public function getUserName()
    {
        $user = User::findOne($this->tomb->user_id);
        return $user->username;
    }

    public function getCustomerName()
    {
        $customer = Customer::findOne($this->tomb->customer_id);
        return $customer->name;
    }

    public function getGrave()
    {
        $grave = Grave::findOne($this->tomb->grave_id);
        return $grave->name;
    }

    public function getTotal()
    {
        return $this->order->price;
    }

    public function getTombPrice()
    {
        $rel = OrderRel::find()->where([
            'order_id'=>$this->order->id,
            'type'=>OrderRel::TYPE_TOMB,
            'status'=>OrderRel::STATUS_NORMAL])
            ->one();
        if (!$rel) {
            return 0;
        }

        return $rel->price;
    }

    /**
     * @return int
     * todo 待
     */
    public function getBuryPrice()
    {
        return 0;
    }

    /**
     * todo 待
     */
    public function getInsPrice()
    {
        return 0;
    }

    /**
     * @return int
     * todo 待
     */
    public function getGoodsPrice()
    {
        return 0;
    }


    public function getGuideName()
    {
        return $this->tomb->guide->username;
    }

    public function getThisPay()
    {
        return $this->pay->total_pay;
    }

    public function getThisPayment()
    {
        return StringHelper::num2rmb($this->pay->total_pay) . '整';
    }

    public function getRefundPrice()
    {
        return $this->refund->price;
    }

    public function getRefundPriceRmb()
    {
        return StringHelper::num2rmb($this->refund->price) . '整';
    }

    public function getNote($type='order')
    {
        if ($type == 'order') {
            return $this->order->note;
        }

        if ($type == 'refund') {
            return $this->refund->note;
        }
    }

    public function getAlreadyPay()
    {
        return $this->order->getTotalPay();

    }

    public function getAlreadyPayRmb()
    {
        return StringHelper::num2rmb($this->order->getTotalPay()) . '整';
    }
    public function getShouldPay()
    {
        return $this->order->price;
    }

    public function getShouldPayRmb()
    {
        return StringHelper::num2rmb($this->order->price);
    }

    public function getTime()
    {
        return  date('Y-m-d',$this->order->updated_at);
    }

    /**
     * @name 取碑文
     */
    public function getIns()
    {
        $ins = $this->tomb->ins;

        if (!$ins) {
            return false;
        }
        $result = $ins->toArray();
        $result['front_img'] = $ins->getFront();
        $result['back_img'] = $ins->getBack();

        return $result;
    }

    public function getOrderRels()
    {
        $rels = $this->order->rels;
        if (!$rels) return false;

        return $rels;
    }

    public function getDeads()
    {
        return $this->tomb->deads;
    }



























}