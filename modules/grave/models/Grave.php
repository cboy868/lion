<?php

namespace app\modules\grave\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\core\traits\TreeTrait;
use app\core\models\Attachment;
use app\core\traits\ThumbTrait;

/**
 * This is the model class for table "{{%grave}}".
 *
 * @property integer $id
 * @property integer $pid
 * @property integer $level
 * @property string $code
 * @property string $name
 * @property integer $thumb
 * @property string $intro
 * @property double $area_totle
 * @property double $area_use
 * @property string $price
 * @property integer $status
 * @property integer $user_id
 * @property integer $sort
 * @property integer $is_leaf
 * @property integer $created_at
 */
class Grave extends \app\core\db\ActiveRecord
{

    use TreeTrait;
    use ThumbTrait;


     // -1删除 1建设中,2销售中,3售完
    const STATUS_DELETE = -1;
    const STATUS_BUILD = 1;
    const STATUS_SALE = 2;
    const STATUS_FINISH = 3;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%grave}}';
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
    public function rules()
    {
        return [
            [['pid', 'level', 'status', 'user_id', 'sort', 'is_leaf', 'created_at'], 'integer'],
            [['intro'], 'string'],
            [['area_totle', 'area_use', 'price'], 'number'],
            [['name'], 'required'],
            [['code', 'name'], 'string', 'max' => 255],
            ['thumb', 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pid' => 'Pid',
            'level' => 'Level',
            'code' => 'Code',
            'name' => '墓区名',
            'thumb' => '缩略图',
            'intro' => '介绍',
            'area_totle' => '总面积',
            'area_use' => '使用面积',
            'price' => '墓基价',
            'status' => '状态',
            'user_id' => '添加人',
            'sort' => '排序',
            'is_leaf' => 'Is Leaf',
            'created_at' => '添加时间',
        ];
    }


    public static function getSta($status = null)
    {
        $sta = [
            self::STATUS_DELETE => '删除',
            self::STATUS_BUILD  => '建设中',
            self::STATUS_SALE   => '销售中',
            self::STATUS_FINISH => '售完'
        ];


        if ($status === null) {
            return $sta;
        }


        if (isset($sta[$status])) {
            return $sta[$status];
        }

        return null;
    }

    public function beforeSave($insert)
    {

        if (!parent::beforeSave($insert)) {
            return false;
        }

        if (!$this->pid) {
            $this->pid = 0;
            $this->level = 1;
            return true;
        }

        if ($insert) {
            $parent = self::findOne($this->pid);
            $this->name = $parent->name . $this->name;

        }

        return true;
    }

    // public function getThumb($size='', $default='')
    // {
    //     return Attachment::getById($this->thumb, $size, $default);
    // }

    public function staCount($type = 'total')
    {
        // $tombs = Tomb::find()->where(['grave_id'=>$this->id])
        //                      ->andWhere(['<>', 'status', TOMB::STATUS_DELETE])
        //                      ->select(['id', 'status'])
        //                      ->asArray()
        //                      ->all();

        $counts = Tomb::find()->where(['grave_id'=>$this->id])
                             ->andWhere(['<>', 'status', TOMB::STATUS_DELETE])
                             ->groupBy('status')
                             ->select(['status','COUNT(*) as cnt'])
                             ->indexBy('status')
                             ->asArray()
                             ->all();
        $cnt = [];
        foreach ($counts as $k => $val) {
            $total += $val['cnt'];
            $cnt[$k] = $val['cnt'];
        }

        return $cnt;

    }



}