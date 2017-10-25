<?php

namespace app\modules\mess\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\mess\models\MessCashbook;

/**
 * SearchMessCashbook represents the model behind the search form about `app\modules\mess\models\MessCashbook`.
 */
class SearchMessCashbook extends MessCashbook
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'mess_id', 'type', 'op_id', 'created_at', 'status'], 'integer'],
            [['note'], 'safe'],
            [['unit_price', 'count_price'], 'number'],
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
        $query = MessCashbook::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'mess_id' => $this->mess_id,
            'unit_price' => $this->unit_price,
            'count_price' => $this->count_price,
            'type' => $this->type,
            'op_id' => $this->op_id,
            'created_at' => $this->created_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
