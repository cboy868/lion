<?php

namespace app\modules\memorial\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\memorial\models\Remote;

/**
 * RemoteSearch represents the model behind the search form about `app\modules\memorial\models\Remote`.
 */
class RemoteSearch extends Remote
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'memorial_id', 'tomb_id', 'user_id', 'sku_id', 'order_rel_id', 'thumb', 'status', 'created_at'], 'integer'],
            [['start', 'end', 'video', 'note'], 'safe'],
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
        $query = Remote::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'memorial_id' => $this->memorial_id,
            'tomb_id' => $this->tomb_id,
            'user_id' => $this->user_id,
            'sku_id' => $this->sku_id,
            'order_rel_id' => $this->order_rel_id,
            'start' => $this->start,
            'end' => $this->end,
            'thumb' => $this->thumb,
            'price' => $this->price,
            'status' => $this->status,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'video', $this->video])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
