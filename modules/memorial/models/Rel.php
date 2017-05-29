<?php

namespace app\modules\memorial\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%memorial_rel}}".
 *
 * @property integer $id
 * @property integer $memorial_id
 * @property string $res_name
 * @property integer $res_id
 * @property string $res_title
 * @property string $res_user
 * @property string $res_cover
 * @property integer $created_at
 */
class Rel extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%memorial_rel}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['memorial_id', 'res_name', 'res_id'], 'required'],
            [['memorial_id', 'res_id', 'created_at'], 'integer'],
            [['res_name', 'res_user', 'res_cover'], 'string', 'max' => 200],
            [['res_title'], 'string', 'max' => 255],
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
            'memorial_id' => '纪念馆id',
            'res_name' => '资源类型',
            'res_id' => 'Res ID',
            'res_title' => '标题',
            'res_user' => '发布人',
            'res_cover' => '封面',
            'created_at' => '添加时间',
        ];
    }
}
