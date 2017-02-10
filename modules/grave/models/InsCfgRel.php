<?php

namespace app\modules\grave\models;

use Yii;

/**
 * This is the model class for table "{{%grave_ins_cfg_rel}}".
 *
 * @property integer $grave_id
 * @property integer $cfg_id
 */
class InsCfgRel extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%grave_ins_cfg_rel}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['grave_id', 'cfg_id'], 'required'],
            [['grave_id', 'cfg_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'grave_id' => 'Grave ID',
            'cfg_id' => 'Cfg ID',
        ];
    }
}
