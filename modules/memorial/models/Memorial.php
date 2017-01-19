<?php

namespace app\modules\memorial\models;

use Yii;

/**
 * This is the model class for table "{{%memorial}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $tomb_id
 * @property string $title
 * @property string $custom_title
 * @property string $cover
 * @property string $intro
 * @property integer $privacy
 * @property integer $view_all
 * @property integer $com_all
 * @property integer $tpl
 * @property integer $status
 * @property integer $updated_at
 * @property integer $created_at
 */
class Memorial extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%memorial}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['user_id', 'tomb_id', 'privacy', 'view_all', 'com_all', 'tpl', 'status', 'updated_at', 'created_at'], 'integer'],
            [['intro'], 'string'],
            [['title', 'cover'], 'string', 'max' => 255],
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
            'tomb_id' => '墓位id',
            'title' => '馆名',
            'cover' => '封面',
            'intro' => '生平介绍',
            'privacy' => '隐私',
            'view_all' => '查看次数',
            'com_all' => '评论数',
            'tpl' => '模板',
            'status' => '状态',
            'updated_at' => '更新时间',
            'created_at' => '添加时间',
        ];
    }
}
