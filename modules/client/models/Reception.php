<?php

namespace app\modules\client\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%client_reception}}".
 *
 * @property integer $id
 * @property integer $client_id
 * @property integer $guide_id
 * @property integer $agent_id
 * @property string $car_number
 * @property integer $person_num
 * @property string $start
 * @property string $end
 * @property integer $un_reason
 * @property integer $is_success
 * @property string $note
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Reception extends \app\core\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%client_reception}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id', 'guide_id', 'agent_id', 'person_num', 'un_reason', 'is_success', 'status', 'created_at', 'updated_at', 'type'], 'integer'],
            [['type', 'note'], 'required'],
            [['start', 'end'], 'safe'],
            [['note'], 'string'],
            [['car_number'], 'string', 'max' => 128],
        ];
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
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_id' => 'Client ID',
            'guide_id' => '接待员',
            'agent_id' => '业务员',
            'car_number' => '车牌号',
            'person_num' => '人数',
            'start' => '开始',
            'end' => '结束',
            'un_reason' => '未购原因',
            'is_success' => '成交',
            'note' => '备注',
            'status' => '状态',
            'created_at' => '添加时间',
            'updated_at' => '修改时间',
            'type' => '联系方式'
        ];
    }

    public function getClient()
    {
        return $this->hasOne(Client::className(),['id'=>'client_id']);
    }

    public function getGuide()
    {
        return $this->hasOne(\app\modules\user\models\User::className(),['id'=>'guide_id']);
    }

    public function getAgent()
    {
        return $this->hasOne(\app\modules\user\models\User::className(),['id'=>'agent_id']);
    }

    public function getOp()
    {
        return $this->hasOne(\app\modules\user\models\User::className(),['id'=>'created_by']);
    }

    public function getReason()
    {
        $params = Yii::$app->controller->module->params['unreason'];
        return $params[$this->un_reason];
    }

    public function gettype()
    {
        $params = Yii::$app->controller->module->params['reception_type'];
        return $params[$this->type];
    }

    public function getIsSuccess()
    {
        return $this->is_success ? '是' : '否';
    }
}
