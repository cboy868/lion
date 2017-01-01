<?php

namespace app\modules\shop\models;

use Yii;

/**
 * This is the model class for table "{{%shop_attr_val}}".
 *
 * @property integer $id
 * @property integer $category_id
 * @property integer $attr_id
 * @property string $val
 * @property integer $thumb
 * @property string $price
 * @property integer $status
 */
class AttrVal extends \app\core\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_DEL    = -1;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_av}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_id', 'attr_id', 'status'], 'integer'],
            [['val', 'thumb'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type_id' => '分类id',
            'attr_id' => '属性id',
            'val' => '属性值',
            'thumb' => '封面',
            // 'price' => '价格',
            'status' => '状态',
            'v_cate' => '属性值分类'
        ];
    }

}
