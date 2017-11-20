<?php

namespace app\modules\mess\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%mess_food_category}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $note
 * @property integer $status
 * @property integer $created_at
 */
class MessFoodCategory extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mess_food_category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['status', 'created_at'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['note'], 'string', 'max' => 200],
        ];
    }
    public function behaviors()
    {
        return [
            [
                'class'=>TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at']
                ]
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
            'name' => '分类名',
            'note' => '备注',
            'status' => '状态',
            'created_at' => '添加时间',
        ];
    }

    public static function sel()
    {
        $cate = self::find()->where(['<>','status',MessFoodCategory::STATUS_DELETE])->all();
        return ArrayHelper::map($cate, 'id', 'name');
    }
}
