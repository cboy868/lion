<?php

namespace app\modules\shop\models;

use Yii;

/**
 * This is the model class for table "{{%lg_goods}}".
 *
 * @property integer $id
 * @property integer $goods_id
 * @property string $language
 * @property string $name
 * @property integer $thumb
 * @property string $intro
 * @property string $skill
 * @property string $unit
 */
class LgGoods extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%lg_goods}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_id', 'language'], 'required'],
            [['goods_id', 'thumb'], 'integer'],
            [['intro', 'skill'], 'string'],
            [['language'], 'string', 'max' => 10],
            [['name'], 'string', 'max' => 200],
            [['unit'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goods_id' => 'Goods ID',
            'language' => 'Language',
            'name' => 'Name',
            'thumb' => 'Thumb',
            'intro' => 'Intro',
            'skill' => 'Skill',
            'unit' => 'Unit',
        ];
    }
}
