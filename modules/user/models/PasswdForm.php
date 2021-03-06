<?php

namespace app\modules\user\models;

use Yii;
use yii\base\Model;

/**
 * Signup form
 */
class PasswdForm extends Model
{
    public $oldpassword;
    public $password;
    public $repassword;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['password', 'repassword'], 'required', 'on' => ['update', 'forget', 'passwd']],
            [['oldpassword'], 'required','on' => ['update', 'passwd']],

            ['password', 'string', 'min' => 6],

            ['repassword', 'compare', 'compareAttribute'=>'password', 'message'=>'两次输入密码不一致']

        ];
    }


    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['update'] = ['oldpassword', 'password', 'repassword'];
        $scenarios['forget'] = ['password', 'repassword'];
        $scenarios['passwd'] = ['password', 'repassword', 'oldpassword'];
//        return [
//            'update' => ['oldpassword', 'password', 'repassword'],
//            'forget' => ['password', 'repassword'],
//        ];

        return $scenarios;
    }

    public function attributeLabels()
    {
      return array(
        'oldpassword' => '原始密码',
        'password' => '新密码',
        'repassword' => '新密码确认',
      );
    }


    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function pwd()
    {
        $user = User::findOne(Yii::$app->user->id);

        if ($this->validate() && $user->validatePassword($this->oldpassword)) {

            $user->password = $this->password ;
            $user->generateAuthKey();

            if ($user->save()) {
                return $user;
            }

        } else {
            $this->addError('oldpassword', '原始密码输入错误');
        }

        return null;
    }

    public function forget($model)
    {
        $user = User::findOne($model->user_id);

        if ($this->validate()) {

            $user->password = $this->password ;
            $user->generateAuthKey();

            if ($user->save()) {
                return $user;
            }
        }

        return null;
    }
}
