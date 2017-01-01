<?php

namespace app\modules\cms\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%contact}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $mobile
 * @property string $email
 * @property string $subject
 * @property string $body
 * @property integer $status
 * @property integer $created_at
 * @property string $note
 */
class Contact extends \yii\db\ActiveRecord
{
    const STATUS_UNTREATED = 0;
    const STATUS_TREATED = 1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%contact}}';
    }

    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    Contact::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            // verifyCode needs to be entered correctly
            [['note','intro'], 'string']
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email'     => '邮箱',
            'note'   => '需求',
            'intro'      => '一些辅助内容',
            'created_at' => '添加时间'
        ];
    }

    public static function create($attributes)
    {
        $contact = new static();
        $contact->setAttributes($attributes);
        $contact->ip = Yii::$app->request->userIP;
        if ($contact->save()) {
            return $contact;
        } else {
            return null;
        }
    }

    public static function getStatusLabel($status=null)
    {
        $st = [
            self::STATUS_UNTREATED => '<font color="red">未处理</font>',
            self::STATUS_TREATED   => '<font color="green">已处理</font>'
        ];

        return is_null($status) ? $st : $st[$status];
    }
}
