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

            [['password', 'repassword'], 'required', 'on' => ['update', 'forget']],
            [['oldpassword'], 'required','on' => ['update']],

            ['password', 'string', 'min' => 6],

            ['repassword', 'compare', 'compareAttribute'=>'password']

        ];
    }


    public function scenarios()
    {
        return [
            'update' => ['oldpassword', 'password', 'repassword'],
            'forget' => ['password', 'repassword'],
        ];
    }

    public function attributeLabels()
    {
      return array(
        'oldpassword' => '原始密码',
        'password' => '新密码',
        'repassword' => '再次输入新密码',
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
