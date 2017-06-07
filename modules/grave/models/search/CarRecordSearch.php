<?php

namespace app\modules\grave\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\grave\models\CarRecord;

/**
 * CarRecordSearch represents the model behind the search form about `app\modules\grave\models\CarRecord`.
 */
class CarRecordSearch extends CarRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'tomb_id', 'grave_id', 'car_id', 'driver_id', 'user_num', 'addr_id', 'status', 'order_id', 'order_rel_id', 'is_cremation', 'car_type', 'updated_at', 'created_at'], 'integer'],
            [['dead_id', 'dead_name', 'use_date', 'use_time', 'contact_user', 'contact_mobile', 'addr', 'note'], 'safe'],
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
        $query = CarRecord::find()->orderBy('id desc');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->andWhere([
            'tomb_id' => \app\modules\grave\models\search\TombSearch::searchTomb($params)//$this->searchTomb($params),
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
//            'tomb_id' => $this->tomb_id,
            'grave_id' => $this->grave_id,
            'car_id' => $this->car_id,
            'driver_id' => $this->driver_id,
            'use_date' => $this->use_date,
            'use_time' => $this->use_time,
            'price' => $this->price,
            'user_num' => $this->user_num,
            'addr_id' => $this->addr_id,
            'status' => $this->status,
            'order_id' => $this->order_id,
            'order_rel_id' => $this->order_rel_id,
            'is_cremation' => $this->is_cremation,
            'car_type' => $this->car_type,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'dead_id', $this->dead_id])
            ->andFilterWhere(['like', 'dead_name', $this->dead_name])
            ->andFilterWhere(['like', 'contact_user', $this->contact_user])
            ->andFilterWhere(['like', 'contact_mobile', $this->contact_mobile])
            ->andFilterWhere(['like', 'addr', $this->addr])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
