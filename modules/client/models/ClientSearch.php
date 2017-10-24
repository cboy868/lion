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
    public $start;
    public $end;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'gender', 'age', 'user_id', 'province_id', 'city_id', 'zone_id',
                'guide_id', 'come_from', 'agent_id', 'status', 'created_by', 'created_at', 'updated_at'], 'integer'],
            [['name', 'telephone', 'mobile', 'qq', 'wechat', 'address',
                'note', 'relation','start','end'], 'safe'],
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
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Client::find()
            ->orderBy('id desc')
            ->where(['status'=>Client::STATUS_NORMAL]);

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
            'gender' => $this->gender,
            'age' => $this->age,
            'user_id' => $this->user_id,
            'province_id' => $this->province_id,
            'city_id' => $this->city_id,
            'zone_id' => $this->zone_id,
            'guide_id' => $this->guide_id,
            'agent_id' => $this->agent_id,
            'status' => $this->status,
            'created_by' => $this->created_by,
        ]);


        if ($this->start) {
            $start = strtotime($this->start);
            $query->andFilterWhere(['>', 'created_at', $start]);
        }

        if ($this->end) {
            $end = strtotime('+1 day',strtotime($this->end));
            $query->andFilterWhere(['<', 'created_at', $end]);
        }

        $query->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'telephone', $this->telephone])
                ->andFilterWhere(['like', 'mobile', $this->mobile])
                ->andFilterWhere(['like', 'qq', $this->qq]);

        return $dataProvider;
    }
}
