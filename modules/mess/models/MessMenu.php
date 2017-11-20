<?php

namespace app\modules\mess\models;

use Yii;
use yii\behaviors\TimestampBehavior;
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

    public function behaviors()
    {
        return [
            [
                'class'=>TimestampBehavior::className(),
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'name', 'default_price'], 'required'],
            [['category_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['default_price', 'real_price'], 'number'],
            [['name'], 'string', 'max' => 50],
            [['note'], 'string', 'max' => 200],
            [['cover'], 'safe'],
            [['note'], 'string'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => '分类',
            'name' => '菜单名',
            'default_price' => '默认单价',
            'real_price' => '价格',
            'note' => '备注',
            'cover' => '封面',
            'status' => '状态',
            'category.name' => '分类',
            'created_at' => '添加时间',
            'updated_at' => 'Updated At',
        ];
    }

    public function getCategory()
    {
        return $this->hasOne(MessMenuCategory::className(), ['id'=>'category_id']);
    }
}
