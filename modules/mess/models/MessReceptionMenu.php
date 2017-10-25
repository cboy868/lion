<?php

namespace app\modules\mess\models;

use Yii;

/**
 * This is the model class for table "{{%mess_reception_menu}}".
 *
 * @property integer $id
 * @property integer $day_menu_id
 * @property integer $type
 * @property integer $reception_id
 * @property string $real_price
 * @property double $num
 * @property integer $status
 * @property integer $created_at
 */
class MessReceptionMenu extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mess_reception_menu}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['day_menu_id', 'type', 'reception_id', 'real_price', 'created_at'], 'required'],
            [['day_menu_id', 'type', 'reception_id', 'status', 'created_at'], 'integer'],
            [['real_price', 'num'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'day_menu_id' => 'Day Menu ID',
            'type' => 'Type',
            'reception_id' => 'Reception ID',
            'real_price' => 'Real Price',
            'num' => 'Num',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }
}
