<?php

namespace app\modules\cms\models;


use Yii;
use yii\base\Model;
/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $email;
    public $note;
    public $intro;
    public $verifyCode;

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
            // verifyCode needs to be entered correctly
            // ['verifyCode', 'captcha'],
            ['verifyCode', 'captcha','captchaAction'=>'/cms/admin/contact/captcha'],

            [['note','intro'], 'string']
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
            'note'   => '需求',
            'intro'      => '一些辅助内容',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param  string  $email the target email address
     * @return boolean whether the model passes validation
     */
    public function contact($email)
    {
        if ($this->validate()) {
            Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([$this->email => $this->email])
                // ->setSubject($this->note)
                ->setTextBody($this->note)
                ->send();
            return Contact::create($this->attributes);
        } else {
            return false;
        }
    }
}
