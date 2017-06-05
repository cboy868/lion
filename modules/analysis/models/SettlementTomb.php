<?php

namespace app\modules\analysis\models;

use Yii;
use app\modules\grave\models\Tomb;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%settlement_tomb}}".
 *
 * @property integer $id
 * @property integer $num
 * @property string $amount
 * @property integer $time
 * @property integer $created_at
 */
class SettlementTomb extends \yii\db\ActiveRecord
{
    public static function data($years=3)
    {

        $thisyear = date('Y');
        for ($i=0; $i < $years; $i++) { 
            $year = date('Y', strtotime('-'.$i.' year'));

            if ($year == $thisyear) {
                $data[$year] = self::getDataInTomb($year);
            } else {
                # 1 判断统计表中是否已有统计，如没有，则加入统计 
                // $settle = self::find()->where(['time'=>$year])->one();
                $data[$year] = self::find()->where(['like', 'time', $year . '%', false])->indexBy('time')->asArray()->all();
                if (!$data[$year]) {//没有，则把之前的加入
                    $data[$year] = self::getDataInTomb($year);

                    $connection = Yii::$app->db;
                    $transaction = $connection->beginTransaction();
                    try {
                        $connection->createCommand()->batchInsert(
                                            self::tableName(), [
                                            'num',
                                            'amount',
                                            'time',
                                            'created_at',
                                            ], $data[$year])
                                    ->execute();
                        $transaction->commit();
                    } catch (\Exception $e) {
                        $transaction->rollBack();
                    }
                }
            }
        }

        return $data;
    }

    public static function getDataInTomb($year)
    {
        $tombs = Tomb::find()->where(['like','sale_time',$year])
                             ->andWhere(['>=', 'status', Tomb::STATUS_DEPOSIT])
                             ->select(['price', 'sale_time'])
                             ->asArray()
                             ->all();

        $data = self::initDate($year);;
        foreach ($tombs as $k => $tomb) {
            $m = $year.date('m', strtotime($tomb['sale_time']));
            $q = $year.ceil(date('m', strtotime($tomb['sale_time']))/3);
            $w = $year.'0'.date('W', strtotime($tomb['sale_time']));

            $data[$m]['amount'] += $tomb['price'];
            $data[$q]['amount'] += $tomb['price'];
            $data[$w]['amount'] += $tomb['price'];
            $data[$year]['amount'] += $tomb['price'];

            $data[$m]['num'] += 1;
            $data[$q]['num'] += 1;
            $data[$w]['num'] += 1;
            $data[$year]['num'] += 1;
        }

        return $data;
    }

    /**
     * @name 初始化数据
     */
    public static function initDate($year)
    {

        $time = time();
        //年
        $data[$year]['num'] = 0;
        $data[$year]['amount'] = 0;
        $data[$year]['time'] = $year;
        $data[$year]['created_at'] = $time;

        //月
        for ($i=1; $i <= 12; $i++) { 
            $k = $year . str_pad($i, 2, '0', STR_PAD_LEFT);
            $data[$k]['num'] = 0;
            $data[$k]['amount'] = 0;
            $data[$k]['time'] = $k;
            $data[$k]['created_at'] = $time;
        }

        //季
        for ($i=1; $i <= 4; $i++) { 
            $k = $year . $i;
            $data[$k]['num'] = 0;
            $data[$k]['amount'] = 0;
            $data[$k]['time'] = $k;
            $data[$k]['created_at'] = $time;
        }

        //周
        for ($i=1; $i <= 53; $i++) { 
            $k = $year . str_pad($i, 3, '0', STR_PAD_LEFT);
            $data[$k]['num'] = 0;
            $data[$k]['amount'] = 0;
            $data[$k]['time'] = $k;
            $data[$k]['created_at'] = $time;
        }
        return $data;

    }

        /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%settlement_tomb}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['num', 'time', 'created_at'], 'integer'],
            [['amount'], 'number'],
            [['intro'], 'string'],
            [['created_at'], 'required'],
        ];
    }

        public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    SettlementTomb::EVENT_BEFORE_INSERT => ['created_at'],
                ],
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
            'num' => 'Num',
            'amount' => 'Amount',
            'time' => 'Time',
            'intro' => '管理员统计分析',
            'created_at' => 'Created At',
        ];
    }
}
