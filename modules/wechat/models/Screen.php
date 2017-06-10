<?php

namespace app\modules\wechat\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%wechat_screen}}".
 *
 * @property integer $id
 * @property string $openid
 * @property string $headimgurl
 * @property string $realname
 * @property string $nickname
 * @property string $content
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 */
class Screen extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wechat_screen}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'required'],
            [['created_at', 'status'], 'integer'],
            [['content'], 'string'],
            [['openid', 'headimgurl', 'realname', 'nickname'], 'string', 'max' => 512],
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class'=>TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at']
                ]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'openid' => '微信id',
            'headimgurl' => '头像',
            'realname' => '名字',
            'nickname' => '昵称',
            'content' => '内容',
            'created_at' => '创建时间',
            'status' => 'Status',
        ];
    }

    public static function msg($openid, $msg)
    {
        $user = User::find()->where(['openid'=>$openid])->one();

        $model = new self;
        $model->openid = $openid;
        $model->headimgurl = $user->headimgurl;
        $model->realname = $user->realname;
        $model->nickname = $user->nickname;
        $model->content = $msg;
         $model->save();
         throw new \Exception($model->getErrors());

         return json_encode($model->getErrors());
    }
}
