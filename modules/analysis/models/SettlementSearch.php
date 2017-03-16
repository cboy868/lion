<?php

namespace app\modules\analysis\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\analysis\models\Settlement;

/**
 * SettlementSearch represents the model behind the search form about `app\modules\analysis\models\Settlement`.
 */
class SettlementSearch extends Settlement
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'order_id', 'op_id', 'guide_id', 'agent_id', 'type', 'pay_type', 'year', 'month', 'week', 'day', 'status', 'created_at', 'updated_at'], 'integer'],
            [['price'], 'number'],
            [['settle_time', 'pay_time', 'intro'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Settlement::find();
        $query->andFilterWhere(['<>', 'settle_time', '0000-00-00 00:00:00']);


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'order_id' => $this->order_id,
            'op_id' => $this->op_id,
            'guide_id' => $this->guide_id,
            'agent_id' => $this->agent_id,
            'type' => $this->type,
            'pay_type' => $this->pay_type,
            'price' => $this->price,
            'year' => $this->year,
            'month' => $this->month,
            'week' => $this->week,
            'day' => $this->day,
            // 'settle_time' => $this->settle_time,
            'pay_time' => $this->pay_time,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'intro', $this->intro]);
        $query->andFilterWhere(['like', 'settle_time', $this->settle_time]);

        return $dataProvider;
    }
}
