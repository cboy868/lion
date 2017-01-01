<?php

namespace app\modules\shop\models;

use Yii;
use app\modules\shop\models\MixCate;
/**
 * This is the model class for table "{{%foods_mix}}".
 *
 * @property integer $id
 * @property integer $cate_id
 * @property string $name
 * @property string $cover
 * @property integer $status
 */
class Mix extends \app\core\db\ActiveRecord
{

    const STATUS_ACTIVE = 1;
    const STATUS_DEL = -1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_mix}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mix_cate', 'status'], 'integer'],
            [['name'], 'required'],
            [['name', 'thumb'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mix_cate' => '分类',
            'name' => '食材名',
            'thumb' => '封面',
            'status' => '状态',
        ];
    }

    public function getCate()
    {
        return $this->hasOne(MixCate::className(),['id'=>'mix_cate']);
    }
}
