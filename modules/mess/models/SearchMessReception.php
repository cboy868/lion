<?php

namespace app\modules\mess\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\mess\models\MessReception;

/**
 * SearchMessReception represents the model behind the search form about `app\modules\mess\models\MessReception`.
 */
class SearchMessReception extends MessReception
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'mess_id', 'reception_number', 'status', 'created_at'], 'integer'],
            [['reception_name', 'reception_customer', 'comment'], 'safe'],
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
        $query = MessReception::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'mess_id' => $this->mess_id,
            'reception_number' => $this->reception_number,
            'status' => $this->status,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'reception_name', $this->reception_name])
            ->andFilterWhere(['like', 'reception_customer', $this->reception_customer])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
