<?php

namespace app\modules\grave\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\grave\models\Customer;

/**
 * CustomerSearch represents the model behind the search form about `app\modules\grave\models\Customer`.
 */
class CustomerSearch extends Customer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'tomb_id', 'user_id', 'is_vip', 'created_at', 'updated_at', 'status'], 'integer'],
            [['name', 'phone', 'mobile', 'email', 'second_ct', 'second_mobile', 'units', 'relation', 'vip_desc'], 'safe'],
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
        $query = Customer::find()->where(['<>','status', Customer::STATUS_DELETE])->orderBy('id desc');

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
            'user_id' => $this->user_id,
            'is_vip' => $this->is_vip,
            'created_at' => $this->created_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', trim($this->name)])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'second_ct', $this->second_ct])
            ->andFilterWhere(['like', 'units', $this->units])
            ->andFilterWhere(['like', 'relation', $this->relation])
            ->andFilterWhere(['like', 'vip_desc', $this->vip_desc]);

        if ($params['TombSearch']['grave_id']) {
            $query->andWhere([
                'tomb_id' => \app\modules\grave\models\search\TombSearch::searchTomb($params)//$this->searchTomb($params),
            ]);
        }


        return $dataProvider;
    }
}
