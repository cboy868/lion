<?php

namespace app\modules\mess\models;

use app\modules\user\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%mess_reception}}".
 *
 * @property integer $id
 * @property integer $mess_id
 * @property string $reception_name
 * @property string $reception_customer
 * @property integer $reception_number
 * @property string $comment
 * @property integer $status
 * @property integer $created_at
 */
class MessReception extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mess_reception}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['reception_name', 'reception_customer', 'reception_number', 'day_time'], 'required'],
            [['reception_number', 'status', 'created_at'], 'integer'],
            [['reception_name'], 'string', 'max' => 20],
            [['reception_customer'], 'string', 'max' => 50],
            [['comment'], 'string', 'max' => 200],
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class'=>TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at']
                ]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'reception_name' => '接待人',
            'reception_customer' => '客户名',
            'reception_number' => '接待人数',
            'comment' => '评价',
            'status' => '状态',
            'created_at' => '添加时间',
            'day_time' => '接待时间'
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(),['id'=>'reception_name']);
    }

    public function getMenus()
    {
        return $this->hasMany(MessReceptionMenu::className(),['reception_id'=>'id'])->orderBy('day_time asc');
    }
}
