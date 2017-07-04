<?php

namespace app\modules\ashes\models;

use Yii;

/**
 * This is the model class for table "{{%ashes_box}}".
 *
 * @property integer $id
 * @property integer $log_id
 * @property string $church_no
 * @property integer $area_id
 * @property integer $row
 * @property integer $col
 * @property integer $status
 */
class Box extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ashes_box}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'log_id'], 'required'],
            [['id', 'log_id', 'box_no', 'area_id', 'row', 'col', 'status'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'log_id' => '记录id',
            'box_no' => '柜号',
            'area_id' => '架区id',
            'row' => '排',
            'col' => '列',
            'status' => '状态',
        ];
    }
}
