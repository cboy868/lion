<?php

namespace app\modules\grave\models;

use Yii;

/**
 * This is the model class for table "{{%grave_ins_cfg}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $shape
 * @property integer $is_god
 * @property integer $is_front
 * @property string $note
 * @property integer $sort
 */
class InsCfg extends \app\core\db\ActiveRecord
{

    const SHAPE_H = 'h';
    const SHAPE_V = 'v';


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%grave_ins_cfg}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'is_god', 'note'], 'required'],
            [['is_god', 'is_front', 'sort'], 'integer'],
            [['note'], 'string'],
            [['name'], 'string', 'max' => 100],
            [['shape'], 'string', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '配置名',
            'shape' => '碑型',
            'shapeLabel' => '碑型',
            'is_god' => '是否天主',
            'isGod' => '碑类',
            'is_front' => '碑面',
            'isFront' => '碑面',
            'note' => '备注',
            'sort' => '排序',
        ];
    }


    public function getShapeLabel()
    {
        return $this->shape == 'h' ? '横碑' : '竖碑';
    }

    public function getIsFront()
    {
        $a = [
            0 => '背面',
            1 => '正面',
            2 => '盖板'
        ];

        return $a[$this->is_front];
    }

    public function getIsGod()
    {
        return $this->is_god =  0 ? '普通' : '天主';
    }
}
