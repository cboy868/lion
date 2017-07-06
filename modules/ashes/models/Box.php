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
    const STATUS_FULL = 2;
    const STATUS_EMPTY = 1;
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
            [['row', 'col', 'area_id'], 'required'],
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

    public static function create($area_id, $row, $col)
    {
        $index = 1;
        for ($i=1;$i<=$row;$i++) {
            for ($j=1; $j<=$col; $j++) {
                $model = new self;
                $model->area_id = $area_id;
                $model->row = $i;
                $model->col = $j;
                $model->box_no = $index;
                $model->log_id = 0;
                $index++;
                $model->save();
            }
        }
        return true;
    }

    public function getArea()
    {
        return $this->hasOne(Area::className(), ['id'=>'area_id']);
    }

    public function getLogs()
    {
        return $this->hasMany(Log::className(), ['box_id'=>'id'])
            ->andWhere(['status'=>Log::STATUS_NORMAL])
            ->orderBy('id desc');
    }
}
