<?php

namespace app\modules\shop\models;

use Yii;
use app\core\helpers\ArrayHelper;
use yii\helpers\Html;


/**
 * This is the model class for table "{{%foods_mix_rel}}".
 *
 * @property integer $id
 * @property integer $foods_id
 * @property integer $mix_id
 * @property string $measure
 * @property integer $status
 */
class MixRel extends \app\core\db\ActiveRecord
{
    const TYPE_ZL = 0;
    const TYPE_FL = 1;

    const STATUS_ACTIVE = 1;
    const STATUS_DEL = -1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_mix_rel}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_id', 'mix_id', 'status', 'category_id', 'type', 'mix_cate'], 'integer'],
            [['measure'], 'required'],
            [['measure'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'foods_id' => 'Foods ID',
            'mix_id' => 'Mix ID',
            'measure' => 'Measure',
            'status' => 'Status',
        ];
    }


    public function getMix()
    {
        return $this->hasOne(Mix::className(),['id'=>'mix_id']);
    }

    public static function rels($filters=[])
    {
        $list = self::find()->where(['not in', 'mix_id', $filters])
                            ->andFilterWhere(['type' => self::TYPE_ZL])
                            ->select(['mix_id'])
                            ->asArray()
                            ->all();

        $list = ArrayHelper::getColumn($list, 'mix_id');


        $mixs = Mix::find()->where(['id'=>$list])->all();



        $result = [];
        foreach ($mixs as $k => $mix) {
            $result[$mix->cate->id] = ArrayHelper::toArray($mix->cate);
            $result[$mix->cate->id]['child'][$mix->id] = $mix->name;
        }


        return $result;
    }

    public static function filter($text, $mix_id, $scheme = false)
    {
       
       $filter = Yii::$app->getRequest()->get('filter');
       $filters = explode(',', $filter);
       if (in_array($mix_id, $filters)) {
           return Html::a($text, '#', ['class'=>'button parse-search selected attr-filter', "data-mix"=>$mix_id]);
       }
       return Html::a($text, '#', ['class'=>'button parse-search attr-filter', "data-mix"=>$mix_id]);
    }
}
