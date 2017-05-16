<?php

namespace app\modules\home\models;

use Yii;
use yii\base\Model;
use app\modules\cms\models\Message;
use app\modules\client\models\Client;

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
	public $res_id;
	public $res_name;

	public $verifyCode;


	public function rules()
    {
        return [
            [['username', 'email', 'title', 'mobile'], 'required'],
            ['email', 'email'],
            ['verifyCode', 'captcha', 'captchaAction'=>'/home/default/captcha', 'message'=>'验证码错误，请重试'],
            [['intro'], 'string'],
            [['title', 'company', 'username'], 'string', 'max' => 255],
            [['mobile', 'email'], 'string', 'max' => 50],
            [['qq', 'skype'], 'string', 'max' => 20],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'res_id' => '产品id',
            'title' => '留言主题',
            'term' => '回复截止',
            'company' => '公司名',
            'username' => '姓名',
            'mobile' => '电话',
            'email' => '邮箱',
            'qq' => 'QQ',
            'skype' => 'Skype',
            'intro' => '主要内容',
            'status' => '状态',
            'op_id' => '处理人',
            'verifyCode' => '验证码',
        ];
    }

    public function create()
    {
        if ($this->validate()) {
            $outerTransaction = Yii::$app->db->beginTransaction();
            try {
                $msg = new Message();
                $msg->username = $this->username;
                $msg->mobile = $this->mobile;
                $msg->email = $this->email;
                $msg->title = $this->title;
                $msg->company = $this->company;
                $msg->qq = $this->qq;
                $msg->skype = $this->skype;
                $msg->intro = $this->intro;
                $msg->res_id = $this->res_id;
                $msg->save();

                $client = new Client();
                $client->name = $this->username;
                $client->mobile = $this->mobile;
                $client->email = $this->email;
                $client->note = $this->title. ';' . $this->intro;
                $client->save();

                $outerTransaction->commit();
                return $msg;
            } catch (\Exception $e) {
                echo $e->getMessage();
                $outerTransaction->rollBack();
                return false;
            }

            
        }

        return false;

        
    }
   
}
