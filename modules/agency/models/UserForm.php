<?php

namespace app\modules\agency\models;

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
    public $is_staff;
    public $mobile;
    public $category;
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

            ['mobile', 'string', 'max' => 12],

            ['is_staff', 'required'],

            ['category', 'required'],
            ['category', 'integer'],

            // ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['repassword', 'compare', 'compareAttribute'=>'password']

        ];
    }

    public function attributeLabels()
    {
        return array(
            'username'=> '用户名',
            'email' => '邮箱',
            'password' => '注册密码',
            'repassword' => '再次输入密码',
            'is_staff' => '用户类别',
            'mobile' => '手机',
            'category' => '办事处'
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
            $user->category = $this->category;

            $this->password = $this->password ? $this->password : '999999';
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->is_staff = $this->is_staff;
            $user->status = User::STATUS_ACTIVE;
            if ($user->save()) {
                return $user;
            }
        }

        return null;
    }
}
