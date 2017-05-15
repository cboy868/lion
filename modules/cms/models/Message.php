<?php

namespace app\modules\cms\models;

use app\modules\grave\models\Tomb;
use Yii;
use app\modules\user\models\User;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%message}}".
 *
 * @property integer $id
 * @property integer $goods_id
 * @property string $title
 * @property string $term
 * @property string $product
 * @property string $username
 * @property string $mobile
 * @property string $email
 * @property string $qq
 * @property string $skype
 * @property string $intro
 * @property integer $status
 * @property integer $created_at
 */
class Message extends \app\core\db\ActiveRecord
{
    const STATUS_OK = 2;//完成 
    const STATUS_NORMAL = 1;//待处理
    const STATUS_DEL = -1;//删除

    //res_name goods/tomb

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%message}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['res_id', 'status', 'created_at', 'op_id'], 'integer'],
            [['term'], 'safe'],
            [['username', 'mobile'], 'required'],
            [['intro'], 'string'],
            [['title', 'company', 'username'], 'string', 'max' => 255],
            [['mobile', 'email', 'res_name'], 'string', 'max' => 50],
            [['qq', 'skype'], 'string', 'max' => 20],
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
            'res_id' => '资源id',
            'res_name' => '资源类型',
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
            'created_at' => '添加时间',
        ];
    }


    public function getRes()
    {
        if ($this->res_name == 'goods') {
            return $this->hasOne(Goods::className(),['id'=>'res_id']);
        }

        if ($this->res_name == 'tomb') {
            return $this->hasOne(Tomb::className(), ['id'=>'res_id']);
        }

    }

    public function getUser()
    {
        return $this->hasOne(User::className(),['id'=>'op_id']);
    }
}
