<?php

namespace app\modules\grave\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%grave_ins_cfg_case}}".
 *
 * @property integer $id
 * @property integer $cfg_id
 * @property integer $num
 * @property integer $width
 * @property integer $height
 * @property string $img
 * @property integer $status
 * @property integer $sort
 * @property string $add_time
 */
class InsCfgCase extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%grave_ins_cfg_case}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cfg_id', 'width', 'height'], 'required'],
            [['cfg_id', 'num', 'width', 'height', 'status', 'sort', 'add_time'], 'integer'],
            [['img'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cfg_id' => '主配置id',
            'num' => '人数',
            'width' => '宽',
            'height' => '高',
            'img' => '示例图',
            'status' => '状态',
            'sort' => '排序',
            'add_time' => '添加时间',
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class'=>TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['add_time']
                ]
            ]
        ];
    }

    public function getValues()
    {
        return $this->hasMany(InsCfgValue::className(), ['case_id'=>'id']);
    }

    public function getCfg()
    {
        return $this->hasOne(InsCfg::className(), ['id'=>'cfg_id']);
    }
}
