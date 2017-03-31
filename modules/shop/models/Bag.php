<?php

namespace app\modules\shop\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%shop_bag}}".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $title
 * @property integer $op_id
 * @property string $original_price
 * @property string $price
 * @property integer $thumb
 * @property string $intro
 * @property integer $type
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Bag extends \app\core\db\ActiveRecord
{
    const TYPE_MULTIPLE = 1;//多个
    const TYPE_SINGLE = 2;//单个

    public function types($type = null)
    {
        $t = [
            self::TYPE_MULTIPLE => '多个sku',
            self::TYPE_SINGLE   => '单个sku'
        ];

        if ($type === null) {
            return $t;
        }

        return $t[$type];
    }

    public function getTypeText()
    {
        return self::types($this->type);
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_bag}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'op_id', 'thumb', 'type', 'status', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'required'],
            [['original_price', 'price'], 'number'],
            [['intro'], 'string'],
            [['title'], 'string', 'max' => 255],
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
            'title' => '标题',
            'op_id' => '操作员',
            'original_price' => '原价总和',
            'price' => '卖价',
            'thumb' => '封面',
            'intro' => '介绍',
            'type' => '类型',//单个2 多个sku 1
            'status' => '状态',
            'created_at' => '添加时间',
            'updated_at' => '修改时间',
            'op.username' => '添加人',
            'typeText' => '类型'
        ];
    }

    public function getRels()
    {
        return $this->hasMany(BagRel::className(),['bag_id'=>'id'])->where(['status'=>self::STATUS_NORMAL]);
    }

    public function getOp()
    {
        return $this->hasOne(\app\modules\user\models\User::className(),['id'=>'op_id']);
    }

    public function getCategory()
    {
        if (!$this->category_id) {
            return null;
        }
        return $this->hasOne(Category::className(),['id'=>'category_id']);
    }

}
