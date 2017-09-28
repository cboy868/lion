<?php

namespace app\modules\wechat\models;

use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use app\core\helpers\StringHelper;
use EasyWeChat\Foundation\Application;
/**
 * This is the model class for table "{{%wechat}}".
 *
 * @property integer $id
 * @property string $token
 * @property string $access_token
 * @property string $encodingaeskey
 * @property integer $level
 * @property string $name
 * @property string $original
 * @property string $appid
 * @property string $appsecret
 * @property integer $status
 * @property integer $created_at
 */
class Template extends Model
{

    /**
     * {{first.DATA}}
     * 预约时间：{{keyword1.DATA}}
     * 来访姓名：{{keyword2.DATA}}
     * 来访地点：{{keyword3.DATA}}
     * 来访事由：{{keyword4.DATA}}
     * {{remark.DATA}}
     */
    const TPL_YUYUE = '-8kRYGW0y3OgnZMwGbxrsiJus3MPt_zvQJ1-NLAm3ts';

    /**
     *  {{first.DATA}}
     *   订单编号：{{keyword1.DATA}}
     *   消费项目：{{keyword2.DATA}}
     *   {{remark.DATA}}
     */
    const TPL_ORDER = 'FJhx0MwkrDqoEIVIAFOqVoL94wWeUmTgR5tZeX5pJyI';

    /**
     * {{first.DATA}}
     * 员工姓名：{{keyword1.DATA}}
     * 提醒时间：{{keyword2.DATA}}
     * 任务内容：{{keyword3.DATA}}
     * {{remark.DATA}}
     */
    const TPL_TASK  = 'Gho346qsaCjx9DaItz10HnHuFH1QqD5Ya9lueVOGvDc';

    /**
     *{{first.DATA}}
     *预约人：{{keyword1.DATA}}
     *预约手机：{{keyword2.DATA}}
     *提交时间：{{keyword3.DATA}}
     *{{remark.DATA}}
     */
    const TPL_YUYUE_NOTICE = 'XfnPsfn4oHm9ZynQpbaorpNKcsYjmF7ikKQQq8pcITM';

    public static $first = [
        self::TPL_YUYUE => '恭喜您预约成功！',
        self::TPL_TASK => '您有新任务',
        self::TPL_ORDER=> '您好，您有订单状态改变',
        self::TPL_YUYUE_NOTICE => '您好，有人预约来访问'
    ];

    public static $remark = [
        self::TPL_YUYUE => '期待您的光临，如有疑问，请联系我们',
        self::TPL_TASK => '请注意',
        self::TPL_ORDER=> '详情您可进入个人中心进行查看',
        self::TPL_YUYUE_NOTICE => '请提前准备好接待事宜'
    ];


    public static function send($data, $tpl_id, $user_id)
    {
        $options = Wechat::options();
        $app = new Application($options);
        $notice = $app->notice;

        $wechat = User::find()->where(['user_id'=>$user_id, 'type'=>0])->one();

        if (!$wechat) {
            return false;
        }

        $open_id = $wechat->openid;

        $data['first'] = isset($data['first']) ? $data['first'] : self::$first[$tpl_id];
        $data['remark'] = isset($data['remark']) ? $data['remark'] : self::$first[$tpl_id];

        $messageId = $notice->send([
            'touser' => $open_id,
            'template_id' => $tpl_id,
            'url' => 'http://lion.ibagou.com',
            'data' => $data
        ]);
    }


}
