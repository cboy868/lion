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
 * @property integer $bone_box
 * @property string $pre_bury
 * @property string $bury
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 */
class Dead extends \app\core\db\ActiveRecord
{

    const ALIVE_NO = 0;
    const ALIVE_YES = 1;

    const INS_NO = 0;
    const INS_YES = 1;

    const ADULT_NO = 0;
    const ADULT_YES = 1;//已成年


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
            [['user_id', 'tomb_id', 'memorial_id', 'serial', 'gender', 'sort', 'is_alive', 'is_adult', 'age', 'follow_id', 'is_ins', 'bone_box', 'created_at', 'updated_at', 'status'], 'integer'],
            [['birth', 'fete', 'pre_bury', 'bury'], 'safe'],
            [['desc', 'bone_type'], 'string'],
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
            'dead_name' => '姓名',
            'second_name' => '第二名',
            'dead_title' => '称谓',
            'serial' => '序号',
            'gender' => '性别',
            'birth_place' => '出生地',
            'birth' => '生日',
            'fete' => '祭日',
            'is_alive' => '健在',
            'is_adult' => '已成年',
            'age' => '年龄',
            'follow_id' => '携子',
            'desc' => '描述',
            'is_ins' => '立碑',
            'bone_type' => '安葬性质',
            'bone_box' => '安葬盒类型',
            'pre_bury' => '预葬日期',
            'bury' => '安葬日期',
            'created_at' => '添加时间',
            'updated_at' => '更新时间',
            'status' => '状态',
            'sort' => '排序'
        ];
    }

    public static function alive($alive = null)
    {
        $as = [
            self::ALIVE_YES => '是',
            self::ALIVE_NO => '否',
        ];

        if ($alive === null) {
            return $as;
        }

        return $as[$alive];
    }

    public function getIsAlive()
    {
        return self::alive($this->is_alive);
    }

    public static function ins($ins = null)
    {
        $as = [
            self::INS_YES => '是',
            self::INS_NO => '否',
        ];

        if ($ins === null) {
            return $as;
        }

        return $as[$ins];
    }
    public function getIsIns()
    {
        return self::ins($this->is_ins);
    }

    public static function adult($adult = null)
    {
        $as = [
            self::ADULT_YES => '是',
            self::ADULT_NO => '否',
        ];

        if ($adult === null) {
            return $as;
        }

        return $as[$adult];
    }

    public function getIsAdult()
    {
        return self::adult($this->is_adult);
    }
}
