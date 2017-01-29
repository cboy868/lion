<?php

namespace app\modules\grave\models;

use Yii;

/**
 * This is the model class for table "{{%grave_address}}".
 *
 * @property integer $id
 * @property string $res_name
 * @property integer $res_id
 * @property integer $province_id
 * @property integer $city_id
 * @property integer $zone_id
 * @property string $address
 * @property string $postcode
 * @property string $mobile
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 */
class Address extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%grave_address}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['res_id', 'province_id', 'city_id', 'zone_id', 'created_at', 'updated_at', 'status'], 'integer'],
            [['address'], 'string'],
            [['res_name'], 'string', 'max' => 100],
            [['postcode', 'mobile'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'res_name' => 'Res Name',
            'res_id' => 'Res ID',
            'province_id' => 'Province ID',
            'city_id' => 'City ID',
            'zone_id' => 'Zone ID',
            'address' => 'Address',
            'postcode' => 'Postcode',
            'mobile' => 'Mobile',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }
}
