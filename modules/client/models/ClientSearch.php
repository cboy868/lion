<?php

namespace app\modules\client\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\client\models\Client;

/**
 * ClientSearch represents the model behind the search form about `app\modules\client\models\Client`.
 */
class ClientSearch extends Client
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'gender', 'age', 'user_id', 'province_id', 'city_id', 'zone_id', 'guide_id', 'come_from', 'agent_id', 'status', 'created_by', 'created_at', 'updated_at'], 'integer'],
            [['name', 'telephone', 'mobile', 'qq', 'wechat', 'address', 'note', 'dead_name', 'relation'], 'safe'],
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
        $query = Client::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'gender' => $this->gender,
            'age' => $this->age,
            'user_id' => $this->user_id,
            'province_id' => $this->province_id,
            'city_id' => $this->city_id,
            'zone_id' => $this->zone_id,
            'guide_id' => $this->guide_id,
            'come_from' => $this->come_from,
            'agent_id' => $this->agent_id,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'telephone', $this->telephone])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'qq', $this->qq])
            ->andFilterWhere(['like', 'wechat', $this->wechat])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'dead_name', $this->dead_name])
            ->andFilterWhere(['like', 'relation', $this->relation]);

        return $dataProvider;
    }
}
