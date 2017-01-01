<?php

namespace app\modules\shop\models;

use Yii;

/**
 * This is the model class for table "{{%foods_process}}".
 *
 * @property integer $id
 * @property integer $foods_id
 * @property string $intro
 * @property string $cover
 * @property integer $type
 * @property integer $sort
 */
class Process extends \app\core\db\ActiveRecord
{

    public $img_url;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_process}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_id', 'type', 'sort', 'step'], 'integer'],
            [['intro'], 'string'],
            [['thumb'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'step' => '步骤',
            'goods_id' => 'Foods ID',
            'intro' => 'Intro',
            'thumb' => 'Cover',
            'type' => 'Type',
            'sort' => 'Sort',
        ];
    }
}
