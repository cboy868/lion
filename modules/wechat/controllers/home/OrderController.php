<?php

namespace app\modules\wechat\controllers\home;

use app\modules\grave\models\Tomb;
use app\modules\order\models\Order;
use app\modules\order\models\Pay;
use app\modules\shop\models\Sku;
use yii;
use EasyWeChat\Foundation\Application;
use yii\web\NotFoundHttpException;
use Endroid\QrCode\QrCode;
use EasyWeChat\Payment\Order as WechatOrder;

class OrderController extends \app\core\web\HomeController
{
    public $enableCsrfValidation = false; //这是一定要的，否则接收不到微信的post数据


    /**
     * @param $tomb_id
     * @param $sku_id
     * @param $num
     * @param $use_time
     * @name 生成商品二维码
     */
    public function actionQrGoods($tomb_id, $sku_id, $num, $use_time, $note, $type)
    {
        $proid = $tomb_id .'.'.$sku_id . '.' .$num . '.' . $use_time . '.' . $type.'.'.$note;

        if (!$tomb_id) {
            $qrCode = new QrCode('此纪念馆未关联墓位,不能办理远程祭祀业务');
            header('Content-Type: '.$qrCode->getContentType());
            echo $qrCode->writeString();
            die;
        }

        $option = $this->getOptions();

        $app = new Application($option);

        $payment = $app->payment;

        $url = $payment->scheme($proid);

        $qrCode = new QrCode($url);
        header('Content-Type: '.$qrCode->getContentType());
        echo $qrCode->writeString();
    }

    /**
     * @param $proid
     * 微信扫码回调此方法生成订单
     */
    public function actionOrder()
    {
        $option = $this->getOptions();

        $app = new Application($option);

        $payment = $app->payment;

        $response = $payment->handleScanNotify(function($pro_id,$openid) use ($payment){
            $arr = explode('.', $pro_id, 6);
            $sku_id = $arr[1];
            $sku = Sku::findOne($sku_id);
            $extra = [
                'tid' => $arr[0],
                'num' => $arr[2],
                'use_time' => $arr[3],
                'type' => $arr[4],
                'note' => $arr[5]
            ];
            $tomb = Tomb::findOne($arr[0]);

            $oInfo = $sku->order($tomb->user_id, $extra);
            if (!$oInfo) {
                Yii::error($pro_id.'订单创建失败',__METHOD__);
                return false;
            }
            $rel = $oInfo['rel'];
            $order = $oInfo['order'];
            $pay = Pay::create($order);

            if (!$pay) {
                Yii::error('订单'.$order->id.'创建支付记录失败',__METHOD__);
                return false;
            }
            $attr = [
                'trade_type' => 'NATIVE',
                'body' => $rel->title,
                'detail' => $rel->title,
                'out_trade_no'     => $pay->order_no,
                'total_fee'        => $order->price * 100,
                'openid'           => $openid
            ];
            $order = new WechatOrder($attr);
            $result = $payment->prepare($order);

            if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS'){
                return $result->prepay_id;
            }

            return false;
        });

        $response->send();
    }

    /**
     * @name 支付完成后反回结果
     */
    public function actionNotify()
    {
        $option = $this->getOptions();

        $app = new Application($option);

        $response = $app->payment->handleNotify(function($notify, $successful){
            // 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单

            $pay = Pay::find()->where(['order_no'=>$notify->out_trade_no])->one();

            if (!$pay) { // 支付记录不存在
                return 'Order not exist.'; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
            }
            // 如果订单存在
            // 检查订单是否已经更新过支付状态
            if ($pay->pay_result == Pay::RESULT_FINISH) {
                return true; // 已经支付成功了就不再更新了
            }
            // 用户是否支付成功
            if ($successful) {
                $pay->on(Pay::EVENT_AFTER_PAY, [$pay->order, 'afterPay']);
                $pay->pay(Pay::METHOD_WECHAT, $notify->total_fee/100, $notify->transaction_id);
            } else { // 用户支付失败
                $pay->status = Pay::STATUS_FAIL;
                $pay->save();
            }
            return true; // 返回处理完成
        });

        $response->send();
    }


    /**
     * @return array
     * @todo 多商户时  这里如何设置
     */
    private function getOptions()
    {
        $params  = Yii::$app->getModule('wechat')->params;

        $options = [
            'debug'  => $params['debug'],
            'log' => $params['log'],
            'app_id' => $params['wx']['appid'],
            'secret' => $params['wx']['appsecret'],
            'token' => $params['wx']['token'],
            'payment' => [
                'merchant_id'        => $params['payment']['merchant_id'],
                'key'                => $params['payment']['key'],
                'cert_path'          => $params['payment']['cert_path'], // XXX: 绝对路径！！！！
                'key_path'           => $params['payment']['key_path'],      // XXX: 绝对路径！！！！
                'notify_url'         => $params['payment']['notify_url'],       // 你也可以在下单时单独设置来想覆盖它
            ],
        ];

        return $options;
    }


//    public function actionMiniOrder()
//    {
//        $id = Yii::$app->request->post('order_id');
//        $openId = Yii::$app->request->post('openid');
//
//        $order = Order::findOne($id);
//
//        if (!$order) {
//            return ['errno'=>1, 'error'=>'无此订单'];
//        }
//
//        if ($order->progress >= Order::PRO_PAY) {
//            return ['errno'=>1, 'error'=> '订单已支付'];
//        }
//
//        $rels = $order->rels;
//
//        $detail = '';
//        $body = $rels[0]->title;
//        foreach ($rels as $v) {
//            $detail .= $v->title. ',';
//        }
//
//        $pay = Pay::create($order);
//
//        $attr = [
//            'trade_type' => 'NATIVE',
//            'body' => $body . '等',
//            'detail' => $detail,
//            'out_trade_no'     => $pay->order_no,
//            'total_fee'        => $order->price * 100,
//            'openid'           => $openId
//        ];
//
//        $options = $this->getMiniOptions();
//
//
//        $app = new Application($options);
//
//        $order = new WechatOrder($attr);
//
//        $payment = $app->payment;
//
//        $result = $payment->prepare($order);
//
//        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS'){
//
//            return [
//                'appid' => $options['app_id'],
//                'prepayId' => $result->prepay_id,
//                'timeStamp' => time(),
//                'nonceStr' => uniqid(),
//            ];
//        }
//
//        return ['errno'=>1, 'error'=>'统一支付失败,请联系管理员'];
//    }
//
//    private function getMiniOptions()
//    {
//        $params  = Yii::$app->getModule('wechat')->params;
//
//        $options = [
//            'debug'  => $params['debug'],
//            'log' => $params['log'],
//            'app_id' => $params['miniProgram']['appid'],
//            'secret' => $params['miniProgram']['appsecret'],
////            'token' => $params['wx']['token'],
//            'payment' => [
//                'merchant_id'        => $params['payment']['merchant_id'],
//                'key'                => $params['payment']['key'],
//                'cert_path'          => $params['payment']['cert_path'], // XXX: 绝对路径！！！！
//                'key_path'           => $params['payment']['key_path'],      // XXX: 绝对路径！！！！
//                'notify_url'         => $params['payment']['notify_url'],       // 你也可以在下单时单独设置来想覆盖它
//            ],
//        ];
//
//        return $options;
//    }


    protected function findTombModel($id)
    {
        if (($model = Tomb::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
