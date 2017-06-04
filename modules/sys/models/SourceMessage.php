<?php

namespace app\modules\sys\models;

use Yii;

/**
 * This is the model class for table "{{%source_message}}".
 *
 * @property integer $id
 * @property string $category
 * @property string $message
 *
 * @property TargetMessage[] $targetMessages
 */
class SourceMessage extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%source_message}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message'], 'string'],
            [['category'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category' => '分类',
            'message' => '翻译内容',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTargetMessages()
    {
        return $this->hasMany(TargetMessage::className(), ['id' => 'id']);
    }
}
