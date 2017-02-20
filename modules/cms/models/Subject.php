<?php

namespace app\modules\cms\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%subject}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $link
 * @property string $cover
 * @property string $path
 * @property integer $status
 * @property integer $updated_at
 * @property integer $created_at
 */
class Subject extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%subject}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'status', 'updated_at', 'created_at'], 'integer'],
            [['user_id', 'title', 'link'], 'required'],
            [['title', 'link', 'cover', 'path'], 'string', 'max' => 200],
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'title' => '标题',
            'link' => '链接',
            'cover' => '封面',
            'path' => '路径',
            'status' => '状态',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }
}
