<?php

namespace app\modules\client\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\client\models\Reception;

/**
 * ReceptionSearch represents the model behind the search form about `app\modules\client\models\Reception`.
 */
class ReceptionSearch extends Reception
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'client_id', 'guide_id', 'agent_id', 'person_num', 'un_reason', 'is_success', 'status', 'created_at', 'updated_at'], 'integer'],
            [['car_number', 'start', 'end', 'note'], 'safe'],
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
        $query = Reception::find();

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
            'client_id' => $this->client_id,
            'guide_id' => $this->guide_id,
            'agent_id' => $this->agent_id,
            'person_num' => $this->person_num,
            'start' => $this->start,
            'end' => $this->end,
            'un_reason' => $this->un_reason,
            'is_success' => $this->is_success,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'car_number', $this->car_number])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
