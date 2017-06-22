<?php

namespace app\modules\wechat\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%wechat_user}}".
 *
 * @property integer $id
 * @property integer $gid
 * @property string $openid
 * @property integer $user_id
 * @property string $nickname
 * @property string $remark
 * @property integer $sex
 * @property string $language
 * @property string $city
 * @property string $province
 * @property string $country
 * @property string $headimgurl
 * @property integer $subscribe
 * @property integer $subscribe_at
 * @property integer $created_at
 * @property string $realname
 * @property string $mobile
 * @property string $birth
 * @property string $addr
 */
class User extends \app\core\db\ActiveRecord
{
    private $_sysuser;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wechat_user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gid', 'user_id', 'sex', 'subscribe', 'subscribe_at', 'created_at'], 'integer'],
            [['openid'], 'required'],
            [['birth'], 'safe'],
            [['addr'], 'string'],
            [['openid', 'nickname', 'remark', 'city', 'province', 'country', 'headimgurl', 'realname'], 'string', 'max' => 255],
            [['language'], 'string', 'max' => 120],
            [['mobile'], 'string', 'max' => 12],
        ];
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

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gid' => '分组',
            'openid' => 'Openid',
            'user_id' => '用户',
            'nickname' => '昵称',
            'remark' => 'Remark',
            'sex' => '性别',
            'language' => '语言',
            'city' => '市',
            'province' => '省',
            'country' => '国家',
            'headimgurl' => '头像',
            'subscribe' => '关注',
            'subscribe_at' => '关注时间',
            'created_at' => '添加时间',
            'realname' => '真实姓名',
            'mobile' => '手机号',
            'birth' => '生日',
            'addr' => '地址',
        ];
    }

    public function getTagRel()
    {
        return $this->hasMany(TagRel::className(), ['openid'=>'openid']);
    }

    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['tag_id' => 'tag_id'])
            ->viaTable(TagRel::tableName(), ['openid' => 'openid']);
    }

    public function getSysUser()
    {
        if ($this->_sysuser === null) {
            $this->_sysuser = \app\modules\user\models\User::findIdentity($this->user_id);
        }


        p($this->_sysuser);die;

        return $this->_sysuser;
    }

    public function login()
    {
        return Yii::$app->user->login($this->getSysUser(), 3600*24*30);
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }




//
//    public function createOpendId()
//    {
//
//    }


}
