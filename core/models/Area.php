<?php

namespace app\core\models;

use Yii;
use app\core\helpers\ArrayHelper;
/**
 * This is the model class for table "{{%area}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $level
 * @property integer $upid
 * @property integer $list
 */
class Area extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%area}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['level', 'upid', 'list'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '地名',
            'level' => 'Level',
            'upid' => 'Upid',
            'list' => 'List',
        ];
    }



    public static function getProvince($level = 1, $type = null)
    {
        $query = self::find();
        if (is_null($type)) {
            $query->where(['level'=>$level]);
        } else {
            $condition = 'level <= 3';
            $query->where(['<=', 'level', 3]);
        }

        return $query->asArray()->all();
    }



    public static function getText($pro_id=0, $city_id=0, $zone_id=0) 
    {
        $option = array(
            'id' => array('in', array(
                $pro_id, $city_id, $zone_id
            )),
        );


        $records = self::find()->where(['id'=>[$pro_id, $city_id, $zone_id]])->asArray()->all();

        return implode(' ', ArrayHelper::getColumn($records, 'name'));
    }


    /**
     * 获取下级数据
     * @param  int   $id
     * @return array 
     */
    public static function getLowerList($id)
    {
        return self::find()->where(['upid'=>$id])->asArray()->all();
    }



    
    public function getArea($pid,$cid,$zid){

        $option = array(
            'id' => array('in', array(
                $pro_id, $city_id, $zone_id
            )),
        );


        $records = self::find()->where(['id'=>[$pro_id, $city_id, $zone_id]])->indexBy('id')->asArray()->all();

        return $records[$pid] .' ' . $records[$cid] . ' ' . $records[$zid];
    }
}
