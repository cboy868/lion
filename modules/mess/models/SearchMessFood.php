<?php

namespace app\modules\mess\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\mess\models\MessFood;

/**
 * SearchMessFood represents the model behind the search form about `app\modules\mess\models\MessFood`.
 */
class SearchMessFood extends MessFood
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'unit_id', 'status', 'created_at'], 'integer'],
            [['food_name'], 'safe'],
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
        $query = MessFood::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
            'unit_id' => $this->unit_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'food_name', $this->food_name]);

        return $dataProvider;
    }
}
