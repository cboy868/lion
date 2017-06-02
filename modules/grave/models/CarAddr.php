<?php

namespace app\modules\grave\models;

use Yii;

/**
 * This is the model class for table "{{%grave_car_addr}}".
 *
 * @property integer $id
 * @property string $title
 * @property integer $type
 * @property integer $time
 * @property integer $status
 * @property integer $created_at
 */
class CarAddr extends \app\core\db\ActiveRecord
{
    const TYPE_LONG = 2;
    const TYPE_SHORT = 1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%grave_car_addr}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'time', 'status', 'created_at'], 'integer'],
            [['title', 'time'], 'required'],
            [['title'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '地址',
            'type' => '类型',
            'time' => '用时(分钟)',
            'status' => '状态',
            'created_at' => '添加时间',
        ];
    }

    public static function types($type=null)
    {
        $t = [
            self::TYPE_SHORT => '短途',
            self::TYPE_LONG  => '长途'
        ];

        if ($type === null) {
            return $t;
        }

        return $t[$type];
    }

    public function gettp()
    {
        return self::types($this->type);
    }

    public static function times()
    {
        return [
            '30' => '0.5小时',
            '60' => '1小时',
            '90' => '1.5小时',
            '120' => '2小时',
            '150' => '3.5小时',
            '180' => '3小时',
            '210' => '3.5小时',
            '240' => '4小时',
            '270' => '4.5小时',
            '300' => '5小时',
            '330' => '5.5小时',
            '360' => '6小时',
        ];
    }
}
