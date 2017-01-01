<?php

namespace app\modules\cms\models;

use Yii;
use yii\base\Model;
/**
 * ContactForm is the model behind the contact form.
 */
class EmailForm extends Model
{
    public $email;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['email'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],

            ['email', 'unique', 'targetClass' => '\app\modules\cms\models\Contact', 'message' => '此邮箱已提交成功，谢谢您的支持。'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => '验证码',
            'email'     => '邮箱',
            // 'note'   => '需求',
            // 'intro'      => '一些辅助内容',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param  string  $email the target email address
     * @return boolean whether the model passes validation
     */
    public function contact($email)
    {

        $adminEmail = Yii::$app->params['adminEmail'];


        $this->email = $email;
        if ($this->validate()) {
            // Yii::$app->mailer->compose()
            //     ->setTo($email)
            //     ->setFrom([$adminEmail => $adminEmail])
            //     // ->setSubject($this->note)
            //     // ->setTextBody('测试')
            //     ->setHtmlBody("<br> 这里是一些测试内容 ")    //发布可以带html标签的文本
            //     ->send();
            return Contact::create($this->attributes);
        } else {
            return false;
        }
    }
}
