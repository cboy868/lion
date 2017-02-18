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
            [['created_at'], 'required'],
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
            'title' => 'Title',
            'type' => 'Type',
            'time' => 'Time',
            'status' => 'Status',
            'created_at' => 'Created At',
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
}
