<?php

namespace app\modules\mess\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\mess\models\MessDayMenuFood;

/**
 * SearchMessDayMenuFood represents the model behind the search form about `app\modules\mess\models\MessDayMenuFood`.
 */
class SearchMessDayMenuFood extends MessDayMenuFood
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'day_menu_id', 'menu_id', 'food_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['num', 'unit_price'], 'number'],
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
        $query = MessDayMenuFood::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'day_menu_id' => $this->day_menu_id,
            'menu_id' => $this->menu_id,
            'food_id' => $this->food_id,
            'num' => $this->num,
            'unit_price' => $this->unit_price,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }
}
