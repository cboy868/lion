<?php

namespace app\modules\mess\models;

use Yii;

/**
 * This is the model class for table "{{%mess_menu}}".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $name
 * @property string $default_price
 * @property string $real_price
 * @property string $note
 * @property string $cover
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class MessMenu extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mess_menu}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'name', 'default_price', 'real_price', 'note', 'cover', 'created_at', 'updated_at'], 'required'],
            [['category_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['default_price', 'real_price'], 'number'],
            [['name'], 'string', 'max' => 50],
            [['note'], 'string', 'max' => 200],
            [['cover'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'name' => 'Name',
            'default_price' => 'Default Price',
            'real_price' => 'Real Price',
            'note' => 'Note',
            'cover' => 'Cover',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
