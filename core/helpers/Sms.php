<?php 
namespace app\core\helpers;

use Yii;

/**
* @name 短信发送类
*/
class Sms
{

    //$result = \app\core\helpers\Sms::send(15910470214, '测试的');
    public static function send($mobile, $content, $time='')
    {
        if (!$content) {
            return null;
        }
        $randStr = str_shuffle('1234567890');  
        $code = substr($randStr,0,4);

        $url = "http://service.winic.org:8009/sys_port/gateway/index.asp?"; //提交的url地址\
        $data = "id=%s&pwd=%s&to=%s&content=%s&time=" . $time;

        $params = Yii::$app->params['sms'];
        $content = iconv("UTF-8","GB2312",$content);
        $rdata = sprintf($data, $params['id'], $params['pwd'], $mobile, $content);
        
        $result = \app\core\helpers\Curl::strPost($url, $rdata);
        $result= substr( $result, 0, 3 );  //获取信息发送后的状态
        return $result;
    }

    /**
     * @name 取余额
     */
    public static function balance()
    {
        $url = 'http://service.winic.org:8009/webservice/public/remoney.asp?';
        $data = "uid=%s&pwd=%s";
        $params = Yii::$app->params['sms'];
        $result = \app\core\helpers\Curl::strPost($url, sprintf($data, $params['id'], $params['pwd']));
        return $result;
    }

}
