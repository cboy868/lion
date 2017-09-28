<?php

namespace app\modules\grave\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\grave\models\CardRel;

/**
 * CardRelSearch represents the model behind the search form about `app\modules\grave\models\CardRel`.
 */
class CardRelSearch extends CardRel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'card_id', 'tomb_id', 'order_id', 'total', 'num', 'created_by', 'created_at', 'updated_at'], 'integer'],
            [['start', 'end', 'customer_name', 'mobile'], 'safe'],
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
        $query = CardRel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 30,
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'card_id' => $this->card_id,
            'tomb_id' => $this->tomb_id,
            'start' => $this->start,
            'end' => $this->end,
            'order_id' => $this->order_id,
            'price' => $this->price,
            'total' => $this->total,
            'num' => $this->num,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'customer_name', $this->customer_name])
            ->andFilterWhere(['like', 'mobile', $this->mobile]);

        return $dataProvider;
    }
}
