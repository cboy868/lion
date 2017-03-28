<?php

namespace app\modules\grave\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\modules\grave\models\Dead;
use app\modules\grave\models\Tomb;
use app\modules\user\models\User;
use app\core\models\Area;
use app\core\helpers\ArrayHelper;


/**
 * This is the model class for table "{{%grave_customer}}".
 *
 * @property integer $id
 * @property integer $tomb_id
 * @property integer $user_id
 * @property string $name
 * @property string $phone
 * @property string $mobile
 * @property string $email
 * @property string $second_ct
 * @property string $second_mobile
 * @property string $units
 * @property string $relation
 * @property integer $is_vip
 * @property string $vip_desc
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 */
class Customer extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%grave_customer}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tomb_id', 'name'], 'required'],
            [['tomb_id', 'user_id', 'is_vip', 'created_at', 'updated_at', 'status', 'province', 'city', 'zone', 'client_id'], 'integer'],
            [['vip_desc', 'addr'], 'string'],
            [['name'], 'string', 'max' => 200],
            [['phone', 'mobile', 'second_mobile'], 'string', 'max' => 20],
            [['email', 'second_ct', 'relation'], 'string', 'max' => 100],
            [['units'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tomb_id' => 'Tomb ID',
            'user_id' => 'User ID',
            'name' => '客户名',
            'phone' => '家庭电话',
            'province' =>'省',
            'city' => '市',
            'zone' => '区',
            'addr' => '联系地址',
            'mobile' => '手机号',
            'email' => '邮箱',
            'second_ct' => '第二联系人',
            'second_mobile' => '第二联系人电话',
            'units' => 'Units',
            'relation' => '关系',
            'is_vip' => '是否vip',
            'vip_desc' => 'vip描述',
            'created_at' => '添加时间',
            'updated_at' => '修改时间',
            'status' => '状态',
        ];
    }
    public function behaviors()
    {
        return [
            [
                'class'=>TimestampBehavior::className(),
            ]
        ];
    }


    public function getDeads()
    {
        return $this->tomb->deads;
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getTomb()
    {
        return $this->hasOne(Tomb::className(), ['id' => 'tomb_id']);
    }

    public function getClient()
    {
        return $this->hasOne(\app\modules\client\models\Client::className(), ['id' => 'client_id']);
    }

    public function getAddress()
    {
        return \app\core\models\Area::getText($this->province, $this->city, $this->zone);
    }
}
