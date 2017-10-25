<?php

namespace app\modules\mess\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\mess\models\MessStorageRecord;

/**
 * SearchMessStorageRecord represents the model behind the search form about `app\modules\mess\models\MessStorageRecord`.
 */
class SearchMessStorageRecord extends MessStorageRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'supplier_id', 'mess_id', 'food_id', 'type', 'created_at'], 'integer'],
            [['number', 'unit_price', 'count_price'], 'number'],
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
        $query = MessStorageRecord::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'supplier_id' => $this->supplier_id,
            'mess_id' => $this->mess_id,
            'food_id' => $this->food_id,
            'number' => $this->number,
            'unit_price' => $this->unit_price,
            'count_price' => $this->count_price,
            'type' => $this->type,
            'created_at' => $this->created_at,
        ]);

        return $dataProvider;
    }
}
