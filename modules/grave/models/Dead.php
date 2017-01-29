<?php

namespace app\modules\grave\models;

use Yii;

/**
 * This is the model class for table "{{%grave_dead}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $tomb_id
 * @property integer $memorial_id
 * @property string $dead_name
 * @property string $second_name
 * @property string $dead_title
 * @property integer $serial
 * @property integer $gender
 * @property string $birth_place
 * @property string $birth
 * @property string $fete
 * @property integer $is_alive
 * @property integer $is_adult
 * @property integer $age
 * @property integer $follow_id
 * @property string $desc
 * @property integer $is_ins
 * @property integer $bone_type
 * @property integer $bone_container
 * @property string $pre_bury
 * @property string $bury
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 */
class Dead extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%grave_dead}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'tomb_id', 'dead_name', 'dead_title'], 'required'],
            [['user_id', 'tomb_id', 'memorial_id', 'serial', 'gender', 'is_alive', 'is_adult', 'age', 'follow_id', 'is_ins', 'bone_type', 'bone_container', 'created_at', 'updated_at', 'status'], 'integer'],
            [['birth', 'fete', 'pre_bury', 'bury'], 'safe'],
            [['desc'], 'string'],
            [['dead_name', 'second_name', 'dead_title', 'birth_place'], 'string', 'max' => 255],
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
            'tomb_id' => 'Tomb ID',
            'memorial_id' => 'Memorial ID',
            'dead_name' => 'Dead Name',
            'second_name' => 'Second Name',
            'dead_title' => 'Dead Title',
            'serial' => 'Serial',
            'gender' => 'Gender',
            'birth_place' => 'Birth Place',
            'birth' => 'Birth',
            'fete' => 'Fete',
            'is_alive' => 'Is Alive',
            'is_adult' => 'Is Adult',
            'age' => 'Age',
            'follow_id' => 'Follow ID',
            'desc' => 'Desc',
            'is_ins' => 'Is Ins',
            'bone_type' => 'Bone Type',
            'bone_container' => 'Bone Container',
            'pre_bury' => 'Pre Bury',
            'bury' => 'Bury',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }
}
