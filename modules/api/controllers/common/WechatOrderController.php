<?php
namespace app\modules\api\controllers\common;

use app\modules\api\models\common\Order;
use app\modules\order\models\Pay;
use function EasyWeChat\Payment\generate_sign;
use Yii;
use EasyWeChat\Foundation\Application;
use EasyWeChat\Payment\Order as WechatOrder;
/**
 * Site controller
 */
class WechatOrderController extends WechatController
{
    public $modelClass = 'app\modules\api\models\common\Order';

    public function behaviors() {
        return parent::behaviors();
    }

    public function actions() {
        $actions = parent::actions();
        unset($actions['delete'], $actions['create']);
        return $actions;
    }


    public function actionMiniOrder()
    {
        $id = Yii::$app->request->post('order_id');
        $openId = Yii::$app->request->post('openid');

        $order = Order::findOne($id);

        if (!$order) {
            return ['errno'=>1, 'error'=>'无此订单'];
        }

        if ($order->progress >= Order::PRO_PAY) {
            return ['errno'=>1, 'error'=> '订单已支付'];
        }

        $rels = $order->rels;

        $detail = '';
        $body = $rels[0]->title;
        foreach ($rels as $v) {
            $detail .= $v->title. ',';
        }

        $pay = Pay::create($order);

        $params = Yii::$app->getModule('wechat')->params;

        $attr = [
            'trade_type' => $params['miniProgram']['trade_type'],
            'body' => $body . '等',
            'detail' => $detail,
            'out_trade_no'     => $pay->order_no,
            'total_fee'        => $order->price * 100,
            'openid'           => $openId
        ];


        $app = $this->initMiniProgramPay();

        $order = new WechatOrder($attr);

        $payment = $app->payment;

        $result = $payment->prepare($order);


        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS'){


            $response = [
                'appId' => $params['miniProgram']['appid'],
                'package' => 'prepay_id='.$result->prepay_id,
                'timeStamp' => time(),
                'nonceStr' => uniqid(),
                'signType' =>'MD5'
            ];

            $sign = generate_sign($response, $params['payment']['key']);

            return [
                'package' => $response['package'],
                'timeStamp' => (string)(time()),
                'nonceStr' => $response['nonceStr'],
                'paySign' => $sign,
            ];
        }

        return ['errno'=>1, 'error'=>$result->err_code_des];
    }
}
