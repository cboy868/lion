<?php

namespace app\modules\grave\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\grave\models\Withdraw;

/**
 * WithdrawSearch represents the model behind the search form about `app\modules\grave\models\Withdraw`.
 */
class WithdrawSearch extends Withdraw
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'guide_id', 'user_id', 'tomb_id', 'current_tomb_id', 'refund_id', 'in_tomb_id', 'status', 'updated_at', 'created_at'], 'integer'],
            [['ct_name', 'ct_mobile', 'ct_card', 'ct_relation', 'reson', 'note'], 'safe'],
            [['price'], 'number'],
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
        $query = Withdraw::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'guide_id' => $this->guide_id,
            'user_id' => $this->user_id,
            'tomb_id' => $this->tomb_id,
            'current_tomb_id' => $this->current_tomb_id,
            'refund_id' => $this->refund_id,
            'price' => $this->price,
            'in_tomb_id' => $this->in_tomb_id,
            'status' => $this->status,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'ct_name', $this->ct_name])
            ->andFilterWhere(['like', 'ct_mobile', $this->ct_mobile])
            ->andFilterWhere(['like', 'ct_card', $this->ct_card])
            ->andFilterWhere(['like', 'ct_relation', $this->ct_relation])
            ->andFilterWhere(['like', 'reson', $this->reson])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
