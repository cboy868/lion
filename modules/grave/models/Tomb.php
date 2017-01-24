<?php

namespace app\modules\grave\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%grave_tomb}}".
 *
 * @property integer $id
 * @property integer $grave_id
 * @property integer $row
 * @property integer $col
 * @property string $special
 * @property string $tomb_no
 * @property integer $hole
 * @property string $price
 * @property string $cost
 * @property double $area_total
 * @property double $area_use
 * @property integer $user_id
 * @property integer $customer_id
 * @property integer $agent_id
 * @property integer $agency_id
 * @property integer $guide_id
 * @property string $sale_time
 * @property string $note
 * @property integer $thumb
 * @property integer $created_at
 * @property integer $status
 */
class Tomb extends \app\core\db\ActiveRecord
{

    // 1删除,1闲置，2预定，3定金 4全款，5 部分安葬 6全部安葬 7单葬
    const STATUS_DELETE = -1;
    const STATUS_EMPTY = 1;
    const STATUS_PRE = 2;
    const STATUS_DEPOSIT = 3;
    const STATUS_PAYOK = 4;
    const STATUS_PART = 5;
    const STATUS_ALL = 6;
    const STATUS_SINGLE = 7;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%grave_tomb}}';
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
    public function rules()
    {
        return [
            [['grave_id', 'row', 'col', 'hole', 'user_id', 'customer_id', 'agent_id', 'agency_id', 'guide_id', 'created_at', 'status'], 'integer'],
            [['price', 'cost', 'area_total', 'area_use'], 'number'],
            [['sale_time', 'thumb'], 'safe'],
            [['note'], 'string'],
            [['grave_id', 'tomb_no', 'row', 'col', 'price'], 'required'],
            [['special'], 'string', 'max' => 100],
            [['tomb_no'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'grave_id' => '墓区',
            'row' => '排',
            'col' => '号',
            'special' => 'Special',
            'tomb_no' => '墓位号',
            'hole' => '墓穴个数',
            'price' => '墓价',
            'cost' => 'Cost',
            'area_total' => '建筑面积',
            'area_use' => '使用面积',
            'user_id' => '用户',
            'customer_id' => '客户',
            'agent_id' => '业务员',
            'agency_id' => '办事处',
            'guide_id' => '导购员',
            'sale_time' => '销售时间',
            'note' => '备注',
            'thumb' => '封面',
            'created_at' => '添加时间',
            'status' => '状态',
        ];
    }

    public static function getSta($status = null)
    {
        $sta = [
            self::STATUS_DELETE => '删除',
            self::STATUS_EMPTY => '闲置',
            self::STATUS_PRE => '预定',
            self::STATUS_DEPOSIT => '定金',
            self::STATUS_PAYOK => '全款',
            self::STATUS_PART => '部分安葬',
            self::STATUS_ALL => '全部安葬',
            self::STATUS_SINGLE => '单葬'
        ];

        if ($status == null) {
            return $sta;
        }

        return isset($sta[$status]) ? $sta[$status] : '';

    }

}
