<?php

namespace app\modules\user\models;

use Yii;
use yii\base\Model;
use app\modules\user\models\User;
use app\modules\user\models\Token;
use yii\captcha\Captcha;
use app\core\helpers\Url;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class ForgetForm extends Model
{
    public $email;
    public $verifyCode;

    private $_user;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['email', 'verifyCode'], 'required'],
            // rememberMe must be a boolean value
            ['email', 'email'],

            ['verifyCode', 'captcha', 'captchaAction'=>'/member/default/captcha'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => '邮箱',
            'verifyCode' => '验证码',
        ];
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    public function create()
    {

        if ($this->validate()) {

            $user = $this->getUser();
            if (!$user) {
                return false;
            }

            $token = new Token;
            $token->code = Yii::$app->security->generateRandomString();
            $token->user_id = $user->id;
            $token->type = $user->status == User::STATUS_ACTIVE ? Token::TYPE_RESET : Token::TYPE_REGISTER;

            if ($token->save()) {
                $url = Url::toRoute(['/member/user/default/token', 'code'=>$token->code], true);

                $mailer = Yii::$app->mailer->compose('@app/core/views/mail/layout', ['content'=>$this->note($url)]);

                $mailer->setTo($this->email)->setSubject('某某某公司找回密码');
                if ($mailer->send()) {
                    return $token;
                };
            }
        }

        return null;
    }

    public function note($url)
    {
        $content = <<<EMAIL
        <p>您好，请点击以下连接找回密码,如果浏览器不跳转，可直接复制连接到浏览器:</p>
        <p><a href="$url">$url</a></p>
EMAIL;
        return $content;
    }



    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {

        if ($this->_user === null) {
            $this->_user = User::findByEmail($this->email);
        }


        return $this->_user;
    }
}
