<?php

namespace app\modules\wechat\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\core\helpers\StringHelper;

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
class Wechat extends \app\core\db\ActiveRecord
{

    const LEVEL_DINGYUE = 1;//订阅
    const LEVEL_DINGYUE_AHTU = 2;//认证订阅
    const LEVEL_FUWU = 3;//服务号
    const LEVEL_FUWU_AUTH = 4;//认证服务号

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wechat}}';
    }

    public function behaviors()
    {
        return [
            [
                'class'=>TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at']
                ]
            ]
        ];
    }

    public static function levels($level=null)
    {
        $ls = [
            self::LEVEL_DINGYUE => '订阅号',
            self::LEVEL_DINGYUE_AHTU =>'认证订阅号',
            self::LEVEL_FUWU => '服务号',
            self::LEVEL_FUWU_AUTH => '认证服务号'
        ];

        if ($level === null) {
            return $ls;
        }

        return $ls[$level];
    }

    public function getLevelLabel()
    {
        return self::levels($this->level);
    }



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['token', 'level', 'name', 'original', 'appid', 'appsecret'], 'required'],
            [['level', 'status', 'created_at'], 'integer'],
            [['token', 'access_token', 'encodingaeskey'], 'string', 'max' => 255],
            [['name', 'original'], 'string', 'max' => 200],
            [['appid', 'appsecret'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'token' => 'Token',
            'access_token' => 'Access Token',
            'encodingaeskey' => 'Encodingaeskey',
            'level' => '公众号类型',
            'name' => '公众号名',
            'original' => '原始id',
            'appid' => 'AppId',
            'appsecret' => 'Appsecret',
            'status' => '状态',
            'created_at' => 'Created At',
        ];
    }

    public function generateToken()
    {
        $this->token = StringHelper::range(32);
    }

    public function generateAeskey()
    {
        $this->encodingaeskey = StringHelper::range(43);
    }

    public static function options()
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
}
