<?php

namespace app\modules\grave\models;

use Yii;

/**
 * This is the model class for table "{{%grave_ins}}".
 *
 * @property integer $id
 * @property integer $guide_id
 * @property integer $user_id
 * @property integer $tomb_id
 * @property integer $op_id
 * @property string $position
 * @property integer $shape
 * @property string $content
 * @property string $img
 * @property integer $is_tc
 * @property integer $font
 * @property integer $font_num
 * @property integer $new_font_num
 * @property integer $is_confirm
 * @property string $confirm_date
 * @property integer $confirm_by
 * @property string $pre_finish
 * @property string $finish_at
 * @property string $note
 * @property integer $version
 * @property integer $paint
 * @property integer $is_stand
 * @property string $paint_price
 * @property string $letter_price
 * @property string $tc_price
 * @property integer $status
 * @property integer $updated_at
 * @property integer $created_at
 */
class Ins extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%grave_ins}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['guide_id', 'user_id', 'tomb_id', 'updated_at', 'created_at'], 'required'],
            [['guide_id', 'user_id', 'tomb_id', 'op_id', 'shape', 'is_tc', 'font', 'font_num', 'new_font_num', 'is_confirm', 'confirm_by', 'version', 'paint', 'is_stand', 'status', 'updated_at', 'created_at'], 'integer'],
            [['content', 'note'], 'string'],
            [['confirm_date', 'pre_finish', 'finish_at'], 'safe'],
            [['paint_price', 'letter_price', 'tc_price'], 'number'],
            [['position'], 'string', 'max' => 100],
            [['img'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'guide_id' => 'Guide ID',
            'user_id' => 'User ID',
            'tomb_id' => 'Tomb ID',
            'op_id' => 'Op ID',
            'position' => 'Position',
            'shape' => 'Shape',
            'content' => 'Content',
            'img' => 'Img',
            'is_tc' => 'Is Tc',
            'font' => 'Font',
            'font_num' => 'Font Num',
            'new_font_num' => 'New Font Num',
            'is_confirm' => 'Is Confirm',
            'confirm_date' => 'Confirm Date',
            'confirm_by' => 'Confirm By',
            'pre_finish' => 'Pre Finish',
            'finish_at' => 'Finish At',
            'note' => 'Note',
            'version' => 'Version',
            'paint' => 'Paint',
            'is_stand' => 'Is Stand',
            'paint_price' => 'Paint Price',
            'letter_price' => 'Letter Price',
            'tc_price' => 'Tc Price',
            'status' => 'Status',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }
}
