<?php

namespace app\modules\grave\models;

use app\core\helpers\StringHelper;
use app\modules\grave\models\Bury;
use Yii;
use yii\behaviors\TimestampBehavior;
use app\modules\grave\models\CardRel;
use yii\helpers\ArrayHelper;

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
            [['tomb_id', 'start', 'end', 'serial'], 'required'],
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
            'serial'     => '墓证号'
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

    /**
     * @name 墓证信息
     * @desc 用于打印墓证
     */
    public static function info($tomb_id)
    {
        $model = self::find()->where(['tomb_id'=>$tomb_id])->one();
        $rels = $model->rels;

        $tomb = $model->tomb;
        $deads = $tomb->deads;
        $customer = $tomb->customer;
        $bury = Bury::find()->where(['tomb_id'=>$tomb_id])
                            ->andWhere(['status'=>Bury::STATUS_OK])
                            ->andWhere(['<>', 'bury_date', 'null'])
                            ->orderBy('id asc')
                            ->one();
        $order_rel = OrderRel::find()->where([
            'type'=>OrderRel::TYPE_TOMB,
            'tid'=>$tomb_id,
            'status'=>OrderRel::STATUS_NORMAL])->one();

        $dead_names = ArrayHelper::getColumn($deads, 'dead_name');

        $card_dates = [];
        foreach ($rels as $v) {
            $card_dates[] = $v['start'] .' - '. $v['end'];
        }

        $info = [
            'card_no' => $model->serial,
            'tomb_no' => $tomb->tomb_no,
            'deads' => $dead_names,
            'bury_date' => isset($bury->bury_date)? date('Y-m-d', strtotime($bury->bury_date)) : '',
            'customer_name' => $customer->name,
            'card_date' => $model->start,//发证日期
            'card_dates' => $card_dates,
            'price' => isset($order_rel->price) ? $order_rel->price : 0

        ];

        $info['price'] = "人民币".StringHelper::num2rmb($info['price'])."整";

        return $info;

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
            'created_by' => Yii::$app->user->id,
            'serial' => date('Ymd') . str_pad($tomb_id, 5, '0', STR_PAD_LEFT )
        ];

        $card->load($data, '');

        if ($card->save() !== false) {
            return $card;
        }
        return false;
    }

    public static function serial($tomb_id)
    {
        return date('Ymd') . str_pad($tomb_id, 5, '0', STR_PAD_LEFT );
    }

}
