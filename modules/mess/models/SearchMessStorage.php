<?php

namespace app\modules\mess\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\mess\models\MessStockLog;

/**
 * SearchMessStockLog represents the model behind the search form about `app\modules\mess\models\MessStockLog`.
 */
class SearchMessStorage extends MessStorage
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'mess_id', 'food_id', 'created_at'], 'integer'],
            [['num', 'unit_price', 'count_price'], 'number'],
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
        $query = MessStorage::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'mess_id' => $this->mess_id,
            'food_id' => $this->food_id,
            'num' => $this->num,
            'unit_price' => $this->unit_price,
            'count_price' => $this->count_price,
            'created_at' => $this->created_at,
        ]);

        return $dataProvider;
    }
}
