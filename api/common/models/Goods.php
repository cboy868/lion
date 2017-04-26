<?php

namespace api\common\models;

use Yii;
use yii\behaviors\TimestampBehavior;


/**
 * This is the model class for table "{{%shop_goods}}".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $name
 * @property integer $thumb
 * @property string $intro
 * @property string $unit
 * @property string $price
 * @property integer $num
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Goods extends \yii\db\ActiveRecord
{

    const STATUS_ACTIVE = 1;
    const STATUS_DEL    = -1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_goods}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'thumb', 'num', 'status', 'created_at', 'updated_at'], 'integer'],
            [['intro', 'skill', 'serial'], 'string'],
            [['price', 'original_price'], 'number'],
            // ['name', 'unique',  'message' => '此菜品已存在，请确定'],
            // [['name', 'price'], 'required'],
            [['name'], 'required'],
            [['name','pinyin'], 'string', 'max' => 255],
            [['unit'], 'string', 'max' => 100]
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
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => '分类',
            'name' => '商品名称',
            'thumb' => '商品封面',
            'intro' => '介绍',
            'skill' => '烹饪技巧',
            'unit' => '单位',
            'price' => '价格',//现价,活动,微信价之类
            'original_price' => '原价',
            'num' => '数量',
            'status' => '状态',
            'tags' => '标签/关键词',
            'recommend' => '是否推荐',
            'created_at' => '添加时间',
            'updated_at' => '更新时间',
            'serial' => '序列号',
            'pinyin' =>'拼音首字母'
        ];
    }
}
