<?php

namespace app\modules\mess\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%mess_supplier}}".
 *
 */
class MessSupplier extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mess_supplier}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mess_id', 'name'], 'required'],
            [['mess_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name','contact','mobile'], 'string', 'max' => 50],
            [['mobile'], 'string', 'max' => 15],
            [['note'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mess_id' => '所属食堂',
            'name' => '供应商名称',
            'note' => '备注',
            'status' => '状态',
            'contact' => '联系人',
            'mobile' => '联系方式',
            'created_at' => '添加时间',
            'updated_at' => '修改时间',
        ];
    }

    public function getMess()
    {
        return $this->hasOne(Mess::className(), ['id'=>'mess_id']);
    }
}
