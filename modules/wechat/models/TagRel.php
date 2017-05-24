<?php

namespace app\modules\wechat\models;

use Yii;

/**
 * This is the model class for table "{{%wechat_tag_rel}}".
 *
 * @property integer $tag_id
 * @property integer $user_id
 */
class TagRel extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wechat_tag_rel}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tag_id', 'user_id'], 'required'],
            [['tag_id', 'user_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tag_id' => 'Tag ID',
            'user_id' => 'User ID',
        ];
    }

    public function getTagUser($id)
    {

    }
}
