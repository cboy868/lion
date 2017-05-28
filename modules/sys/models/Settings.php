<?php

namespace app\modules\sys\models;

use Yii;

/**
 * This is the model class for table "{{%sys_settings}}".
 *
 * @property string $sname
 * @property string $svalue
 * @property string $svalues
 * @property string $sintro
 * @property string $stype
 * @property integer $sort
 * @property string $smodule
 */
class Settings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sys_settings}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sname'], 'required'],
            [['svalues'], 'string'],
            [['sort'], 'integer'],
            [['sname', 'sintro', 'stype', 'smodule'], 'string', 'max' => 128],
            [['svalue'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sname' => 'Sname',
            'svalue' => 'Svalue',
            'svalues' => 'Svalues',
            'sintro' => 'Sintro',
            'stype' => 'Stype',
            'sort' => 'Sort',
            'smodule' => 'Smodule',
        ];
    }
}
