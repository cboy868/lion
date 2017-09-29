<?php

namespace app\modules\shop\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\core\behaviors\OpBehavior;
/**
 * This is the model class for table "{{%inventory_supplier}}".
 * 供货商
 */
class InventorySupplier extends \app\core\db\ActiveRecord
{
    const SEX_MALE = 1;
    const SEX_FMALE = 2; //女
    const SEX_UNKNOW = 0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%inventory_supplier}}';
    }

    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    InventorySupplier::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],
            [
                'class' => OpBehavior::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cp_name', 'addr', 'ct_name', 'ct_mobile'], 'required'],
            [['addr', 'note'], 'string'],
            [['ct_sex', 'created_by', 'created_at', 'status'], 'integer'],
            [['cp_name'], 'string', 'max' => 200],
            [['cp_phone', 'ct_mobile'], 'string', 'max' => 15],
            [['ct_name'], 'string', 'max' => 255],
            [['qq', 'wechat'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cp_name' => '公司名',
            'cp_phone' => '公司电话',
            'addr' => '公司地址',
            'ct_name' => '联系人',
            'ct_mobile' => '联系人电话',
            'ct_sex' => '联系人性别',
            'qq' => 'QQ',
            'wechat' => '微信号',
            'note' => '备注',
            'created_by' => '添加人',
            'created_at' => '添加时间',
            'statusText' => '状态',
            'sexText' => '性别',
            'by.username'=> '添加人'
        ];
    }

    /**
     * @name 性别
     */
    public static function males($s = null)
    {
        $m = [
            self::SEX_UNKNOW => '未知',
            self::SEX_FMALE => '女士',
            self::SEX_MALE  => '先生'
        ];

        if ($s === null) {
            return $m;
        }

        return $m[$s];
    }

    public function getSexText()
    {
        return self::males($this->ct_sex);
    }

    public function getBy()
    {
        return $this->hasOne(\app\modules\user\models\User::className(), ['id'=>'created_by']);
    }

}
