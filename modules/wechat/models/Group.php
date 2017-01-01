<?php

namespace app\modules\wechat\models;

use Yii;

/**
 * This is the model class for table "{{%wechat_group}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $count
 */
class Group extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wechat_group}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['count'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'count' => 'Count',
        ];
    }
}
