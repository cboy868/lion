<?php

namespace app\modules\api\models\common;

use app\modules\user\models\Addition;
use Yii;
use yii\base\Model;

/**
 * Signup form
 */
class UserForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $repassword;
    public $mobile;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\app\modules\user\models\User', 'message' => '此用户名已被占用,请尝试新的用户名.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\modules\user\models\User', 'message' => '此邮箱已被使用'],

            // ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['repassword', 'compare', 'compareAttribute'=>'password'],

            [['mobile'], 'safe']

        ];
    }

    public function attributeLabels()
    {
        return array(
            'username'=> '用户名',
            'email' => '邮箱',
            'password' => '注册密码',
            'repassword' => '再次输入密码',
        );
    }


    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function create()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;

            $this->password = $this->password ? $this->password : '999999';
            $user->setPassword($this->password);
            $user->mobile = $this->mobile;
            $user->generateAuthKey();
            $user->is_staff = User::STAFF_NO;
            $user->status = User::STATUS_ACTIVE;
            if ($user->save()) {
                $addition = new Addition();
                $addition->user_id = $user->id;
                $addition->save();
                return $user;
            }
        }

        return null;
    }
}

