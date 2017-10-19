<?php

namespace app\modules\grave\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%grave_bury}}".
 *
 * @property integer $id
 * @property integer $tomb_id
 * @property integer $user_id
 * @property integer $dead_id
 * @property integer $dead_name
 * @property integer $dead_num
 * @property integer $bury_type
 * @property string $pre_bury_date
 * @property string $bury_date
 * @property string $bury_time
 * @property integer $bury_user
 * @property integer $bury_order
 * @property string $note
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 */
class Bury extends \app\core\db\ActiveRecord
{
    const STATUS_OK = 2;//安葬完成

    const TYPE_SHOU = 1;//寿穴
    const TYPE_DAN = 2;//单葬
    const TYPE_HE = 3;//合葬
    const TYPE_DU = 4;//独葬
    const TYPE_ER = 5;//二次合葬

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%grave_bury}}';
    }

    public function behaviors()
    {
        return [
            [
                'class'=>TimestampBehavior::className(),
            ]
        ];
    }

    public static function types($type = null)
    {
        $t = [
            self::TYPE_SHOU => '寿穴',
            self::TYPE_DAN  => '单葬',
            self::TYPE_HE   => '合葬',
            self::TYPE_DU   => '独葬',
            self::TYPE_ER   => '二次合葬'
        ];

        if ($type !== null  && isset($t[$type])) {
            return $t[$type];
        }

        return $t;
    }

    public function getType()
    {
        return $this->bury_type ? self::types($this->bury_type) : '';
    }

    /**
     * 判断bury_type 类型
     */
    public function generalType()
    {
        $dead_count = Dead::find()->where(['status'=>Dead::STATUS_NORMAL,'tomb_id'=>$this->tomb_id])->count();

        if ($dead_count == 1) { //独
            return self::TYPE_DU;
        }

        if ($this->dead_num == $dead_count) {//合葬
            return self::TYPE_HE;
        }

        if ($this->dead_num < $dead_count) {
            $deads = Dead::find()->where(['status'=>Dead::STATUS_NORMAL,'tomb_id'=>$this->tomb_id])->all();
            $has_bury = false;
            foreach ($deads as $dead) {
                if ($dead['bury'] != null) {
                    $has_bury = true;
                    break;
                }
            }

            if ($has_bury) {
                return self::TYPE_ER;
            } else {
                return self::TYPE_DAN;
            }
        }
        return self::TYPE_SHOU;
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tomb_id', 'user_id', 'dead_num', 'pre_bury_date'], 'required'],
            [['dead_id', 'dead_name'], 'required', 'message'=> '请选择使用人'],

            [['tomb_id', 'user_id', 'dead_num', 'bury_type', 'bury_user',
                'bury_order', 'created_at', 'updated_at', 'status'], 'integer'],
            [['pre_bury_date', 'bury_date', 'bury_time'], 'safe'],
            [['note', 'dead_id','dead_name'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tomb_id' => 'Tomb ID',
            'user_id' => 'User ID',
            'dead_id' => 'Dead ID',
            'dead_name' => '使用人',
            'dead_num' => '逝者数量',
            'type' => '安葬类型',
            'pre_bury_date' => '安葬日期',
            'bury_date' => '实际安葬日期',
            'bury_time' => '安葬时间',
            'bury_user' => 'Bury User',
            'bury_order' => 'Bury Order',
            'note' => '备注',
            'created_at' => '添加时间',
            'updated_at' => 'Updated At',
            'status' => 'Status',
            'buser.username' => '安葬员'
        ];
    }

    public function getTomb()
    {
        return $this->hasOne(Tomb::className(),['id'=>'tomb_id']);
    }

    public function getUser()
    {
        return $this->hasOne(\app\modules\user\models\User::className(),['id'=>'user_id']);
    }

    public function getBuser()
    {
        return $this->hasOne(\app\modules\user\models\User::className(),['id'=>'bury_user']);
    }

    public function getDeads()
    {
        $dead_ids = explode(',', $this->dead_id);
        $deads = Dead::find()->where(['id'=>$dead_ids, 'status'=>self::STATUS_NORMAL])->all();

        return $deads;
    }



}
