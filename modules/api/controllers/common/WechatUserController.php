<?php
namespace app\modules\api\controllers\common;

use app\modules\api\models\common\Order;
use app\modules\order\models\Pay;
use Yii;
use app\modules\api\models\common\UserForm;
use app\modules\api\models\common\WechatUser;
use app\modules\api\models\common\User;
use EasyWeChat\Foundation\Application;
use EasyWeChat\Payment\Order as WechatOrder;
/**
 * Site controller
 */
class WechatUserController extends Controller
{
    public $modelClass = 'app\modules\api\models\common\WechatUser';

    public function behaviors() {
        return parent::behaviors();
    }

    public function actions() {
        $actions = parent::actions();
        unset($actions['delete'], $actions['create']);
        return $actions;
    }



    public function actionBind()
    {
        $post = Yii::$app->request->post();

        $user = User::findByUsername($post['uname']);

        if (!$user) {
            return ['errno'=>1, 'error'=>'用户名或密码不正确，请重试'];
        }

        if (!$user->validatePassword($post['passwd'])) {
            return ['errno'=>1, 'error'=>'用户名或密码不正确，请重试'];
        }

        $wecheat_user = WechatUser::findOne($post['wechat_uid']);

        if ($wecheat_user->user_id) {
            return ['errno'=>1, 'error'=>'用户已绑定，如需更换，请联系工作人员'];
        }


        $wecheat_user->user_id = $user->id;

        return $wecheat_user->save();

    }

    public function actionCreate()
    {
        $post = Yii::$app->request->post();


        $wecheat_user = WechatUser::findOne($post['wechat_uid']);

        if (isset($wecheat_user->user_id)) {
            return ['errno'=>1, 'error'=>'用户已绑定，如需更换，请联系工作人员'];
        }

        $uform = new UserForm();
        $uform->username = $post['uname'];
        $uform->email = $post['email'];
        $uform->password = $post['passwd'];
        $uform->repassword = $post['repasswd'];

        if($user = $uform->create()) {
            $wecheat_user->user_id = $user->id;
            $wecheat_user->save();
            return true;
        }

        $error='';
        if ($errors = $uform->getErrors()) {
            $error =array_shift($errors);
            $error = $error[0];
        }

        return ['errno'=>1, 'error'=>'账户创建失败 '.$error];

    }

    public function actionMiniProLogin($code)
    {

        $params = Yii::$app->request->get();

        $app = $this->initMiniProgram();

        $miniProgram = $app->mini_program;

        $data = $miniProgram->sns->getSessionKey($code);
        $openid = $data['openid'];

        $udata = json_decode($params['udata'], true);


        $class = $this->modelClass;

        $umodel = $class::find()->where(['openid'=>$openid, 'type'=>1])->one();
        if (!$umodel) {
            $umodel = new $class;
            $umodel->load($udata, '');
            $umodel->openid = $openid;
            $umodel->type = $umodel::TYPE_MINI;
            $umodel->nickname = $udata['nickName'];
            $umodel->sex = $udata['gender'];
            $umodel->headimgurl = $udata['avatarUrl'];
            $umodel->save();
        }

        return $umodel;


//        $a = $miniProgram->encryptor->decryptData($data['session_key'], $post['iv'], $post['encryptedData']);


    }


    public function actionAdd()
    {
        $post = Yii::$app->request->post();

        $app = $this->initMiniProgram();
        $miniProgram = $app->mini_program;
        $data = $miniProgram->sns->getSessionKey($code);


        return $post;
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

            return [
                'appid' => $options['app_id'],
                'prepayId' => $result->prepay_id,
                'timeStamp' => time(),
                'nonceStr' => uniqid(),
            ];
        }

        return ['errno'=>1, 'error'=>'统一支付失败,请联系管理员'];
    }

    public function initMiniProgram()
    {
        $options = [
            'mini_program' => [
                'app_id'   => 'wx6b31b3c15e5f1b85',
                'secret'   => '65931a81bde1c9f92e8bd4fea3e5822a',
                'token'    => 'pNxLA9w6dR4D15PbYjnyezSMWriEJvsV',
                'aes_key'  => 'component-aes-key'
            ],
            'debug'  => true,
            'log' => [
                'level'      => 'trace',
                'permission' => 0777,
                'file'       => '/tmp/easywechat.log',
            ]
        ];

        return new Application($options);
    }

    private function getMiniOptions()
    {
        $params  = Yii::$app->getModule('wechat')->params;

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
