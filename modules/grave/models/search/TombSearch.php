<?php

namespace app\modules\grave\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\grave\models\Tomb;

/**
 * TombSearch represents the model behind the search form about `app\modules\grave\models\Tomb`.
 */
class TombSearch extends Tomb
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'grave_id', 'row', 'col', 'hole', 'user_id', 'customer_id', 'agent_id', 'agency_id', 'guide_id', 'thumb', 'created_at', 'status'], 'integer'],
            [['special', 'tomb_no', 'sale_time', 'note'], 'safe'],
            [['price', 'cost', 'area_total', 'area_use'], 'number'],
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
        $query = Tomb::find();



        $dataProvider = new ActiveDataProvider([
            'query' => $query->orderBy('row asc, col asc'),
            'pagination' => [
                'pageSize' => 10000,
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }



        $query->andFilterWhere([
            'id' => $this->id,
            'grave_id' => $this->grave_id,
            'row' => $this->row,
            'col' => $this->col,
            'hole' => $this->hole,
            'price' => $this->price,
            'cost' => $this->cost,
            'area_total' => $this->area_total,
            'area_use' => $this->area_use,
            'user_id' => $this->user_id,
            'customer_id' => $this->customer_id,
            'agent_id' => $this->agent_id,
            'agency_id' => $this->agency_id,
            'guide_id' => $this->guide_id,
            'sale_time' => $this->sale_time,
            'thumb' => $this->thumb,
            'created_at' => $this->created_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'special', $this->special])
            ->andFilterWhere(['like', 'tomb_no', $this->tomb_no])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }


    public static function searchTomb($params)
    {
        $searchModel = new self();
        $dataProvider = $searchModel->search($params);
        $models = $dataProvider->getModels();
        if (!$dataProvider) {
            return false;
        }

        $tomb_id = [];
        foreach ($models as $k => $v) {
            array_push($tomb_id, $v->id);
        }
        return $tomb_id;
    }


}
