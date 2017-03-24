<?php

namespace app\modules\home\models;

use Yii;
use yii\base\Model;
use app\modules\shop\models\Message;
/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class MsgForm extends Model
{

	public $title;
	public $username;
	public $mobile;

	public $intro;
	public $company;
	public $qq;
	public $email;
	public $skype;
	public $goods_id;

	public $verifyCode;


	public function rules()
    {
        return [
            [['username', 'email', 'title', 'goods_id'], 'required'],
            ['email', 'email'],
            ['verifyCode', 'captcha', 'captchaAction'=>'/member/default/captcha', 'message'=>'Error! Please try again '],
            [['intro'], 'string'],
            [['title', 'company', 'username'], 'string', 'max' => 255],
            [['mobile', 'email'], 'string', 'max' => 50],
            [['qq', 'skype'], 'string', 'max' => 20],
        ];
    }

    public function attributeLabels()
    {
        return [
            'verifyCode' => '验证码',
        ];
    }

    public function create()
    {
        if ($this->validate()) {
            $msg = new Message();
            $msg->username = $this->username;
            $msg->mobile = $this->mobile;
            $msg->email = $this->email;
            $msg->title = $this->title;

            $msg->company = $this->company;
            $msg->qq = $this->qq;
            $msg->skype = $this->skype;
            $msg->intro = $this->intro;
            $msg->goods_id = $this->goods_id;
            if ($msg->save()) {
                return $msg;
            }

            p($msg->getErrors());die;
        }


        return false;
    }
   
}
