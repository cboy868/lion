<?php
namespace app\modules\api\controllers\common;

use app\core\helpers\ArrayHelper;
use Yii;
use EasyWeChat\Foundation\Application;
/**
 * Site controller
 */

class WechatController extends Controller
{
    public function behaviors() {
        return parent::behaviors();
    }

    public function actions() {
        $actions = parent::actions();
        unset($actions['delete'], $actions['create']);
        return $actions;
    }


    /**
     * @return Application
     * @name 支付之外用的一些东西
     */
    protected function initMiniProgram()
    {

        $wechatCfg = Yii::$app->getModule('wechat')->params;
        $options = [
            'mini_program' => [
                'app_id'   => $wechatCfg['miniProgram']['appid'],
                'secret'   => $wechatCfg['miniProgram']['appsecret'],
                'token'    => $wechatCfg['miniProgram']['token'],
                'aes_key'  => $wechatCfg['miniProgram']['aes_key'],
            ],
            'debug'  => $wechatCfg['debug'],
            'log' => $wechatCfg['log']
        ];
        return new Application($options);

    }

    protected function initMiniProgramPay()
    {
        $wechatCfg = Yii::$app->getModule('wechat')->params;

        $options = [
            'debug'  => $wechatCfg['debug'],
            'log' => $wechatCfg['log'],
            'app_id' => $wechatCfg['miniProgram']['appid'],
            'secret' => $wechatCfg['miniProgram']['appsecret'],
            'token'    => $wechatCfg['miniProgram']['token'],
            'aes_key'  => $wechatCfg['miniProgram']['aes_key'],
            'payment' => [
                'merchant_id'        => $wechatCfg['payment']['merchant_id'],
                'key'                => $wechatCfg['payment']['key'],
                'cert_path'          => $wechatCfg['payment']['cert_path'], // XXX: 绝对路径！！！！
                'key_path'           => $wechatCfg['payment']['key_path'],      // XXX: 绝对路径！！！！
                'notify_url'         => $wechatCfg['payment']['notify_url'],       // 你也可以在下单时单独设置来想覆盖它
            ],
        ];

        return new Application($options);

    }




}
