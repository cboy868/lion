<?php

namespace app\modules\focus\models;

use Yii;
use app\modules\focus\models\Focus;

/**
 * This is the model class for table "{{%focus_category}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $intro
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%focus_category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['intro'], 'string'],
            [['title'], 'string', 'max' => 100],
            [['thumb'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'intro' => '描述',
            'thumb' => '封面'
        ];
    }

    public function getFocus($limit = 10)
    {
        return $this->hasMany(Focus::className(), ['category_id'=>'id'])->limit($limit);
    }

}
