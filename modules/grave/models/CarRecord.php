<?php

namespace app\modules\grave\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%grave_car_record}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $tomb_id
 * @property integer $grave_id
 * @property string $dead_id
 * @property string $dead_name
 * @property integer $car_id
 * @property integer $driver_id
 * @property string $use_date
 * @property string $use_time
 * @property string $price
 * @property string $contact_user
 * @property string $contact_mobile
 * @property integer $user_num
 * @property integer $addr_id
 * @property string $addr
 * @property integer $status
 * @property string $note
 * @property integer $order_id
 * @property integer $order_rel_id
 * @property integer $is_cremation
 * @property integer $car_type
 * @property integer $updated_at
 * @property integer $created_at
 */
class CarRecord extends \app\core\db\ActiveRecord
{
    const CAR_LING = 1;
    const CAR_FENG = 2;
    const CAR_SELF = 3; 
    
    public function carType($type = null)
    {
        $types = [
            self::CAR_LING => '迎灵车',
            self::CAR_FENG => '风行车',
            self::CAR_SELF => '自驾'
        ];

        if ($type === null) {
            return $types;
        }

        return $types[$type];
    }

    public function getCarType()
    {
        return self::carType($this->car_type);
    }


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%grave_car_record}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'tomb_id','bury_id', 'car_type'], 'required'],
            [['car_type'], 'required', 'message'=> '请选择车类型'],
            [['user_id','is_back', 'tomb_id','bury_id', 'grave_id', 'car_id', 'driver_id', 'user_num', 'addr_id', 'status', 'order_id', 'order_rel_id', 'is_cremation', 'car_type', 'updated_at', 'created_at'], 'integer'],
            [['use_date', 'use_time'], 'safe'],
            [['price'], 'number'],
            [['addr', 'note'], 'string'],
            [['dead_id', 'dead_name', 'contact_user'], 'string', 'max' => 200],
            [['contact_mobile'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'tomb_id' => 'Tomb ID',
            'grave_id' => 'Grave ID',
            'dead_id' => 'Dead ID',
            'dead_name' => 'Dead Name',
            'car_id' => 'Car ID',
            'driver_id' => 'Driver ID',
            'use_date' => '日期',
            'use_time' => '使用时间',
            'price' => 'Price',
            'is_back' => '是否返程',
            'contact_user' => '用车联系人',
            'contact_mobile' => '联系电话',
            'user_num' => '人数',
            'addr_id' => '接盒地点',
            'addr' => '地址',
            'status' => 'Status',
            'note' => '备注',
            'order_id' => 'Order ID',
            'order_rel_id' => 'Order Rel ID',
            'is_cremation' => '是否火化',
            'car_type' => '车类型',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
            'bury_id' => '安葬记录'
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

    public function getDriver()
    {
        if (!$this->driver_id) {
            return '';
        }

        return $this->hasOne(\app\modules\user\models\User::className(),['id'=>'user_id']);
    }

    public function getCar()
    {
        if (!$this->car_id) {
            return '';
        }

        return $this->hasOne(Car::className(),['id'=>'car_id']);
    }

    public function getAddress()
    {
        if (!$this->addr_id) {
            return '';
        }

        return $this->hasOne(CarAddr::className(),['id'=>'addr_id']);
    }

}
