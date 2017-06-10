<?php

namespace app\modules\wechat\controllers\home;

use app\modules\wechat\models\Screen;
use yii;
use app\modules\wechat\models\Wechat;
use EasyWeChat\Foundation\Application;
use yii\web\NotFoundHttpException;

class DefaultController extends \app\core\web\HomeController
{
    public $enableCsrfValidation = false; //这是一定要的，否则接收不到微信的post数据

    public $options = [];

    public $app = null;

    public $wid;



    public function actionIndex($id)
    {
        $this->wid = $id;
        $this->setOptions($id);
        $this->app = new Application($this->options);
        $server = $this->app->server;

        $server->setMessageHandler(function($message){
            // 注意，这里的 $message 不仅仅是用户发来的消息，也可能是事件
            // 当 $message->MsgType 为 event 时为事件

//
//
//
//
//            switch ($message->MsgType) {
//                case 'event':
//                    $event = $message->Event;
//                    return $this->$event($message);
//                    break;
//                case 'text':
//                    return $this->responseMsg($message);
//                    break;
//                default:
//                    # code...
//                    break;
//            }



            switch ($message->MsgType) {
                case 'event':
                    return '收到事件消息';
                    break;
                case 'text':
                    return $this->text($message);
                    break;
                case 'image':
                    return '收到图片消息';
                    break;
                case 'voice':
                    return '收到语音消息';
                    break;
                case 'video':
                    return '收到视频消息';
                    break;
                case 'location':
                    return '收到坐标消息';
                    break;
                case 'link':
                    return '收到链接消息';
                    break;
                // ... 其它消息
                default:
                    return '收到其它消息';
                    break;
            }







            // if ($message->MsgType == 'event') {

            //     $event = $message->Event;

            //     $this->$event($message);
            // } else {
            //     $this->responseMsg($message);
            // }

        });

        echo $server->serve()->send();
    }

    /**
     * @name 处理文字消息
     */
    private function text($msg)
    {
        $content = $msg->Content;
        $content = str_replace('＠', '@', $content);
        $rs = preg_match($this->msg_re, $content, $match);

        if ( !$rs ) {
            // 不匹配@进多客服
            return $this->muti_person_service();
        }

        $action = $match[1];
        if ( !in_array($action, array(6)) ){
            return;
        }

        $text = trim($match[2]);
        if (!$text) return;//没有内容也返回空

        $action = '_text'.$action;

        return $this->$action($text);

    }

    /**
     * @name 大屏留言
     */
    private function text6($msg)
    {
        if (Screen::msg($this->wid,$msg->FromUserName, $msg->Content)) {
            return '您好，祝福留言成功';
        }
        return '您好，留言失败，请重试';

    }

    /**
     * @name 进多客服
     */
    private function muti_person_service()
    {

    }


    private function setOptions($id)
    {
        $account = $this->findModel($id);

        if (!$account) {
            throw new NotFoundHttpException('The requested wechat does not exist.');
        }

        $params  = Yii::$app->getModule('wechat')->params;

        $this->options = [
            'debug'  => $params['debug'],
            'log' => $params['log']
        ];

        $this->options['app_id'] = $account->appid;
        $this->options['secret'] = $account->appsecret;
        $this->options['token']  = $account->token;
    }

    protected function findModel($id)
    {
        if (($model = Wechat::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
