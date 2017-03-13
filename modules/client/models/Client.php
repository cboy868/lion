<?php

namespace app\modules\client\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%client}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $gender
 * @property integer $age
 * @property integer $user_id
 * @property string $telephone
 * @property string $mobile
 * @property string $qq
 * @property string $wechat
 * @property integer $province_id
 * @property integer $city_id
 * @property integer $zone_id
 * @property string $address
 * @property string $note
 * @property integer $guide_id
 * @property integer $come_from
 * @property integer $agent_id
 * @property integer $status
 * @property integer $created_by
 * @property integer $created_at
 * @property integer $updated_at
 */
class Client extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%client}}';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['gender', 'age', 'user_id', 'province_id', 'city_id', 'zone_id', 'guide_id', 'come_from', 'agent_id', 'status', 'created_by', 'created_at', 'updated_at'], 'integer'],
            [['address', 'note'], 'string'],
            [['name', 'telephone', 'mobile', 'qq', 'wechat', 'email'], 'string', 'max' => 128],
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名字 ',
            'gender' => '性别',
            'age' => '年龄',
            'user_id' => '账户id',
            'telephone' => '家庭电话',
            'mobile' => '手机号',
            'email' => '邮箱',
            'qq' => 'QQ号',
            'wechat' => '微信号',
            'province_id' => '省份id',
            'city_id' => '城市id',
            'zone_id' => '区',
            'address' => '详细地址',
            'note' => '备注',
            'guide_id' => '导购员',
            'come_from' => '来源',
            'agent_id' => '业值',
            'status' => '状态',
            'created_by' => '添加人',
            'created_at' => '添加时间',
            'updated_at' => '更新时间',
            'from' => '来源',
            'genderText' => '性别'
        ];
    }

    public function getGuide()
    {
        return $this->hasOne(\app\modules\user\models\User::className(),['id'=>'guide_id']);
    }

    public function getUser()
    {
        return $this->hasOne(\app\modules\user\models\User::className(),['id'=>'user_id']);
    }

    public function getAgent()
    {
        return $this->hasOne(\app\modules\user\models\User::className(),['id'=>'agent_id']);
    }

    public function getOp()
    {
        return $this->hasOne(\app\modules\user\models\User::className(),['id'=>'created_by']);
    }

    public function getReceps()
    {
        return $this->hasMany(Reception::className(),['client_id'=>'id']);
    }

    public function getFrom()
    {
        $params = Yii::$app->controller->module->params['come_from'];
        return $params[$this->come_from];
    }
}
