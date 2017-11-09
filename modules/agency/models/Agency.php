<?php

namespace app\modules\agency\models;

use app\modules\user\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%agency}}".
 *
 * @property integer $id
 * @property string $title
 * @property integer $is_real
 * @property integer $category
 * @property integer $thumb
 * @property integer $leader
 * @property integer $guide
 * @property string $mobile
 * @property string $phone
 * @property string $kefu_qq
 * @property string $addr
 * @property string $intro
 * @property integer $created_at
 * @property integer $status
 */
class Agency extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%agency}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title','category'], 'required'],
            [['id', 'is_real', 'category', 'thumb', 'leader', 'guide', 'created_at', 'status'], 'integer'],
            [['addr', 'intro'], 'string'],
            [['title'], 'string', 'max' => 200],
            [['mobile'], 'string', 'max' => 12],
            [['phone'], 'string', 'max' => 20],
            [['kefu_qq'], 'string', 'max' => 128],
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
            'title' => '名字',
            'is_real' => '是否真实存在',
            'category' => '隶属',
            'thumb' => '店面图',
            'leader' => '负责人',
            'guide' => '导购员',
            'mobile' => '负责人电话',
            'phone' => '办事处电话',
            'kefu_qq' => '客服qq',
            'addr' => '地址',
            'intro' => '介绍及备注',
            'created_at' => '添加时间',
            'status' => '状态',
            'cate' => '隶属'
        ];
    }

    public static function sel()
    {
        $list = self::find()->where(['status'=>self::STATUS_NORMAL])->all();

        $list = ArrayHelper::map($list, 'id', 'title');

        return $list;
    }

    public function getLUser()
    {
        if (!$this->leader) {
            return new User();
        }
        return $this->hasOne(User::className(), ['id'=>'leader']);
    }

    public function getGUser()
    {
        if (!$this->guide){
            return new User();
        }
        return $this->hasOne(User::className(), ['id'=>'guide']);
    }

    public function getCate()
    {
        $cate = Yii::$app->getModule('agency')->categorys();

        return isset($cate[$this->category]) ? $cate[$this->category] : '';
    }
}
