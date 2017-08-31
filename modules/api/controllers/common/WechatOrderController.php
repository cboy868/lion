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
class WechatOrderController extends Controller
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

        $attr = [
            'trade_type' => 'NATIVE',
            'body' => $body . '等',
            'detail' => $detail,
            'out_trade_no'     => $pay->order_no,
            'total_fee'        => $order->price * 100,
            'openid'           => $openId
        ];

        $options = $this->getMiniOptions();


        $app = new Application($options);

        $order = new WechatOrder($attr);

        $payment = $app->payment;

        $result = $payment->prepare($order);


        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS'){

            $response = [
                'appid' => $options['app_id'],
                'prepayId' => $result->prepay_id,
                'timeStamp' => time(),
                'nonceStr' => uniqid(),
            ];


            $sign = generate_sign($response, $options['payment']['key']);


            return $sign;
            return [
                'appid' => $options['app_id'],
                'prepayId' => $result->prepay_id,
                'timeStamp' => time(),
                'nonceStr' => uniqid(),
            ];
        }

        return ['errno'=>1, 'error'=>$result->err_code_des];
    }


    private function getMiniOptions()
    {
        $params = $this->module->params;

        $options = [
            'debug'  => $params['debug'],
            'log' => $params['log'],
            'app_id' => $params['miniProgram']['appid'],
            'secret' => $params['miniProgram']['appsecret'],
//            'token' => $params['wx']['token'],
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

}
