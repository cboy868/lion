<?php

namespace app\modules\grave\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%grave_dead}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $tomb_id
 * @property integer $memorial_id
 * @property string $dead_name
 * @property string $second_name
 * @property string $dead_title
 * @property integer $serial
 * @property integer $gender
 * @property string $birth_place
 * @property string $birth
 * @property string $fete
 * @property integer $is_alive
 * @property integer $is_adult
 * @property integer $age
 * @property integer $follow_id
 * @property string $desc
 * @property integer $is_ins
 * @property integer $bone_type
 * @property integer $bone_box
 * @property string $pre_bury
 * @property string $bury
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 */
class Dead extends \app\core\db\ActiveRecord
{

    const ALIVE_NO = 0;
    const ALIVE_YES = 1;

    const INS_NO = 0;
    const INS_YES = 1;

    const ADULT_NO = 0;
    const ADULT_YES = 1;//已成年


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%grave_dead}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'tomb_id', 'dead_name', 'dead_title'], 'required'],
            [['user_id', 'tomb_id', 'memorial_id', 'serial', 'gender', 'sort', 'is_alive', 'is_adult', 'age', 'follow_id', 'is_ins', 'bone_box', 'created_at', 'updated_at', 'status', 'avatar'], 'integer'],
            [['birth', 'fete', 'pre_bury', 'bury'], 'safe'],
            [['desc', 'bone_type'], 'string'],
            [['dead_name', 'second_name', 'dead_title', 'birth_place'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'tomb_id' => 'Tomb ID',
            'memorial_id' => 'Memorial ID',
            'dead_name' => '姓名',
            'second_name' => '第二名',
            'dead_title' => '称谓',
            'serial' => '序号',
            'gender' => '性别',
            'birth_place' => '出生地',
            'birth' => '生日',
            'fete' => '祭日',
            'is_alive' => '健在',
            'is_adult' => '已成年',
            'age' => '年龄',
            'follow_id' => '携子',
            'desc' => '描述',
            'is_ins' => '立碑',
            'bone_type' => '安葬性质',
            'bone_box' => '安葬盒类型',
            'pre_bury' => '预葬日期',
            'bury' => '安葬日期',
            'created_at' => '添加时间',
            'updated_at' => '更新时间',
            'status' => '状态',
            'sort' => '排序'
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

    public function getTomb()
    {
        return $this->hasOne(\app\modules\grave\models\Tomb::className(),['id'=>'tomb_id']);
    }

    public function getUser()
    {
        return $this->hasOne(\app\modules\user\models\User::className(),['id'=>'user_id']);
    }

    public function getMemorial()
    {
        return $this->hasOne(\app\modules\memorial\models\Memorial::className(),['id'=>'memorial_id']);
    }

    public static function alive($alive = null)
    {
        $as = [
            self::ALIVE_YES => '是',
            self::ALIVE_NO => '否',
        ];

        if ($alive === null) {
            return $as;
        }

        return $as[$alive];
    }

    public function getIsAlive()
    {
        return self::alive($this->is_alive);
    }

    public static function ins($ins = null)
    {
        $as = [
            self::INS_YES => '是',
            self::INS_NO => '否',
        ];

        if ($ins === null) {
            return $as;
        }

        return $as[$ins];
    }
    public function getIsIns()
    {
        return self::ins($this->is_ins);
    }

    public static function adult($adult = null)
    {
        $as = [
            self::ADULT_YES => '是',
            self::ADULT_NO => '否',
        ];

        if ($adult === null) {
            return $as;
        }

        return $as[$adult];
    }

    public function getIsAdult()
    {
        return self::adult($this->is_adult);
    }

    /**
     * @name  判断是否已定安葬
     */
    public function getIsPre()
    {
        if ($this->pre_bury == '0000-00-00 00:00:00' || $this->pre_bury == null) {
            return false;
        }

        return true;
    }

    /**
     * @name  判断是否安葬
     */
    public function getIsBury()
    {
        if ($this->bury == '0000-00-00 00:00:00' || $this->bury == null) {
            return false;
        }

        return true;
    }

    /**
     * @name 判断是否存在待定安葬的逝者
     */
    public static function hasUnPreBury($tomb_id)
    {
        $deads = self::find()->where(['status'=>self::STATUS_NORMAL, 'tomb_id'=>$tomb_id])
                             ->andWhere(['is_alive'=>self::ALIVE_NO])
                             ->all();

        foreach ($deads as $k => $dead) {
            if (!$dead->isPre) {
                return true;
            }
        }

        return false;
    }


    /**
     * @name 取待定安葬的逝者
     */
    public static function getUnPreBury($tomb_id)
    {
        $deads = self::find()->where(['status'=>self::STATUS_NORMAL, 'tomb_id'=>$tomb_id])
                             ->all();
        $unpre = [];
        foreach ($variable as $dead) {
            if (!$dead->isPre && !$dead->is_alive) {
                array_push($unpre, $dead);
            }
        }


        return$unpre;
    }


    public function afterSave($insert, $attr)
    {
        $ins = \app\modules\grave\models\Ins::find()->where(['tomb_id'=>$this->tomb_id])->one();

        if ($ins) {
            $ins->changed = 1;
            return $ins->save();
        }

        return true;
    }

    public static function getBoneTypes()
    {
        return Yii::$app->controller->module->params['bone_type'];
    }

    public static function getBoneBoxs()
    {
        return Yii::$app->controller->module->params['bone_box'];
    }

    public function getBoneBox()
    {
        $bone = Yii::$app->controller->module->params['bone_box'];
        if ($this->bone_box) {
            return $bone[$this->bone_box];
        }
        return '';
    }


    public function getBoneType()
    {
        $types = Yii::$app->controller->module->params['bone_type'];
        if ($this->bone_type) {
            return $types[$this->bone_type];
        }

        return '';
    }

    public function getAvatarImg($size, $default="/static/images/default.png")
    {
        return \app\core\models\Attachment::getById($this->avatar, $size, $default);
    }

    /**
     * @name 取纪念日
     */
    public function getDays()
    {

        $birth = $this->birth;
        $fete = $this->fete;

        $data = [
            [
                'title' => '生辰',
                'date'  => $birth,
            ],
            [
                'title' => '祭日',
                'date'  => $fete,
            ]
        ];


        //other
        $days = Dates::find()->where(['dead_id'=>$this->id])->asArray()->all();

        foreach ($days as $v) {
            $data[] = [
                'title' => $v['title'],
                'date' => $v['solar_dt']
            ];
        }

        //取当前日期
        $current = date('Y-m-d');


        foreach ($data as &$v) {
            $md = date('Y') . date('-m-d', strtotime($v['date']));
            $v['days'] = (strtotime($current) - strtotime($md))/86400;
        }unset($v);

        return $data;

    }
}
