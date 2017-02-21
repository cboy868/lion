<?php

namespace app\modules\shop\models;

use Yii;
use app\modules\user\models\User;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%shop_message}}".
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

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_message}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_id', 'status', 'created_at', 'op_id'], 'integer'],
            [['term'], 'safe'],
            [['username', 'mobile', 'title'], 'required'],
            [['intro'], 'string'],
            [['title', 'company', 'username'], 'string', 'max' => 255],
            [['mobile', 'email'], 'string', 'max' => 50],
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
            'goods_id' => '产品id',
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


    public function getGoods()
    {
        return $this->hasOne(Goods::className(),['id'=>'goods_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(),['id'=>'op_id']);
    }
}
