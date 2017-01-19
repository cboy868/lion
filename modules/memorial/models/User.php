<?php

namespace app\modules\memorial\models;

use Yii;

/**
 * This is the model class for table "{{%memorial_user}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $memorial_id
 * @property string $relation
 * @property string $note
 * @property integer $status
 * @property integer $created_at
 */
class User extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%memorial_user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'memorial_id'], 'required'],
            [['user_id', 'memorial_id', 'status', 'created_at'], 'integer'],
            [['note'], 'string'],
            [['relation'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户id',
            'memorial_id' => '纪念馆id',
            'relation' => '关系',
            'note' => '备注',
            'status' => '状态',
            'created_at' => '添加时间',
        ];
    }
}
