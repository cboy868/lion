<?php

namespace app\modules\grave\models;

use app\modules\grave\models\Bury;
use Yii;
use yii\behaviors\TimestampBehavior;
use app\modules\grave\models\CardRel;
/**
 * This is the model class for table "{{%grave_card}}".
 *
 * @property integer $id
 * @property integer $tomb_id
 * @property string $start
 * @property string $end
 * @property integer $total
 * @property integer $created_by
 * @property integer $created_at
 * @property integer $updated_at
 */
class Card extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%grave_card}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tomb_id', 'start', 'end'], 'required'],
            [['tomb_id', 'total', 'created_by', 'created_at', 'updated_at'], 'integer'],
            [['start', 'end'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tomb_id' => '墓位id',
            'start' => '起始',
            'end' => '截止',
            'total' => '总续费年数',
            'created_by' => '添加人',
            'created_at' => '添加时间',
            'updated_at' => '修改时间',
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
            ]
        ];
    }

    public function getBy()
    {
        return $this->hasOne(\app\modules\user\models\User::className(), ['id' => 'created_by']);
    }

    public function getTomb()
    {
        return $this->hasOne(\app\modules\grave\models\Tomb::className(), ['id' => 'tomb_id']);
    }

    public function getRels()
    {
        return $this->hasMany(CardRel::className(), ['card_id' => 'id'])->orderBy('id asc');
    }

    public static function initCard($tomb_id, $order_rel_id)
    {
        $card = self::find()->where(['tomb_id'=>$tomb_id])->one();
        if ($card) {
           return CardRel::initRel($card, $order_rel_id);
        }

        $tomb_params = Yii::$app->getModule('grave')->params['tomb_card'];
        $start_type = $tomb_params['start'];

        if ($start_type == 'bury'){//如果墓证从安葬日期开始算
            $min_date = Bury::find()
                ->where(['tomb_id'=>$tomb_id])
                ->andWhere(['status'=>Bury::STATUS_OK])
                ->min('bury_date');
        }
        //如果墓证从销售之日开始算
        if ($start_type=='sale_time') {
            $tomb = Tomb::findOne($tomb_id);
            $min_date = $tomb->sale_time;
        }

        if (!$min_date) {//还未安葬
            return $card;
        }
        $card = self::createNew($tomb_id, $min_date);

        if (!$card) {
            //记录日志并且反回空
            Yii::error('墓证初始化失败',__METHOD__);
            return ;
        }

        return CardRel::initRel($card, $order_rel_id);
    }

    public static function createNew($tomb_id, $min_date)
    {
        $tomb_params = Yii::$app->getModule('grave')->params['tomb_card'];
        $card = new self();
        $time = strtotime($min_date);
        $data = [
            'tomb_id' => $tomb_id,
            'start' => $min_date,
            'end' => date('Y-m-d', strtotime('+'.$tomb_params['years'].' years', $time)),
            'total' => $tomb_params['years'],
            'created_by' => Yii::$app->user->id
        ];
        $card->load($data, '');

        if ($card->save() !== false) {
            return $card;
        }
        return false;
    }

}
