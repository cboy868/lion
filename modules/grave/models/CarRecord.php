<?php

namespace app\modules\grave\models;

use app\core\helpers\ArrayHelper;
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

    const STATUS_RECEIVE = 2;
    const STATUS_COMPLETE = 3;
    
    public static function carType($type = null)
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
            [['use_date', 'use_time', 'end_time'], 'safe'],
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
            'updated_at' => '修改时间',
            'created_at' => '添加时间',
            'bury_id' => '安葬记录',
            'end_time' => '结束时间'
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

    /**
     * @name 获取墓位
     */
    public function getTomb()
    {
        return $this->hasOne(Tomb::className(), ['id'=>'tomb_id']);
    }


    public function getDriver()
    {
        if (!$this->driver_id) {
            return '';
        }

        return $this->hasOne(\app\modules\user\models\User::className(),['id'=>'driver_id']);
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

    /**
     * @name 是否有闲置的车辆
     * @param $start 开始时间
     * @param $long 时长
     * @param $type 车辆类型
     * @des 两个条件 或者关系
     * 1、 $use_time < $start  AND $end_time > $start
     * 2、$use_time < $end AND $end_time >($start+$long)
     */
    public static function hasFreeCar($start, $long, $type)
    {
        $total = Car::find()->where(['status'=>Car::STATUS_NORMAL])
                            ->andWhere(['type'=>$type])
                            ->count();

        $date = date('Y-m-d', strtotime($start));
        $start_time = date('H:i', strtotime($start));
        $end_time = date('H:i', strtotime('+'.$long.' minute', strtotime($start)));

        $query = (new \yii\db\Query())->from(CarRecord::tableName())
                                        ->where(['or',
                                            ['and', 'use_time<="'.$start_time.'"', 'end_time>"'.$start_time.'"', 'use_date="'.$date.'"'],
                                            ['and', 'use_time<"'.$end_time.'"', 'end_time>="'.$end_time.'"', 'use_date="'.$date.'"']
                                        ]);
        $cnt = $query->count();

        return $total - $cnt > 0;
    }

    /**
     * @name 占用中的车辆
     */
    public static function useCars($date, $start_time, $end_time)
    {
        $query = (new \yii\db\Query())->from(CarRecord::tableName())
            ->where(['or',
                ['and', 'use_time<="'.$start_time.'"', 'end_time>"'.$start_time.'"', 'use_date="'.$date.'"'],
                ['and', 'use_time<"'.$end_time.'"', 'end_time>="'.$end_time.'"', 'use_date="'.$date.'"']
            ]);
    }

    /**
     * @param $type
     * @name 选择可用车辆
     */
    public function cars()
    {

        $records = (new \yii\db\Query())->from(CarRecord::tableName())
                ->where(['or',
                    ['and', 'use_time<="'.$this->use_time.'"', 'end_time>"'.$this->use_time.'"', 'use_date="'.$this->use_date.'"'],
                    ['and', 'use_time<"'.$this->end_time.'"', 'end_time>="'.$this->end_time.'"', 'use_date="'.$this->use_date.'"']
                ])->all();

        $car_ids = [];
        foreach ($records as $v) {
            if ($v['id'] == $this->id) continue;
            $car_ids[] = $v['car_id'];
        }


        $all_cars = Car::find()->where(['type'=>$this->car_type])->all();

        $all_cars = ArrayHelper::map($all_cars, 'id', 'code');

        $result = [];

        foreach ($all_cars as $k=>$v) {
            if (!in_array($k, $car_ids)) {
                array_push($result, $v);
            }
        }

        return $result;

    }

}
