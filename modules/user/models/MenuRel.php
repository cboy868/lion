<?php

namespace app\modules\user\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%user_menu_rel}}".
 *
 * @property string $menu_group
 * @property integer $user_id
 * @property string $auth_name
 * @property string $ico
 * @property integer $created_at
 * @property integer $id
 */
class MenuRel extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_menu_rel}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['panel', 'user_id', 'auth_name', 'name'], 'required'],
            [['user_id', 'created_at'], 'integer'],
            [['panel'], 'string', 'max' => 50],
            [['auth_name', 'ico'], 'string', 'max' => 255],
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
            'panel' => 'Menu Group',
            'user_id' => 'User ID',
            'auth_name' => 'Auth Name',
            'ico' => 'Ico',
            'created_at' => 'Created At',
            'id' => 'ID',
        ];
    }
}
