<?php

namespace app\modules\ashes\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\ashes\models\Log;

/**
 * LogSearch represents the model behind the search form about `app\modules\ashes\models\Log`.
 */
class LogSearch extends Log
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'action', 'box_id', 'area_id', 'tomb_id', 'out_way', 'op_id', 'status', 'created_at'], 'integer'],
            [['deads', 'bury_date', 'save_user', 'out_user', 'save_time', 'out_time', 'note', 'contact', 'mobile', 'relation'], 'safe'],
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
        $query = Log::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'action' => $this->action,
            'box_id' => $this->box_id,
            'area_id' => $this->area_id,
            'tomb_id' => $this->tomb_id,
            'bury_date' => $this->bury_date,
            'out_way' => $this->out_way,
            'op_id' => $this->op_id,
            'save_time' => $this->save_time,
            'out_time' => $this->out_time,
            'status' => $this->status,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'deads', $this->deads])
            ->andFilterWhere(['like', 'save_user', $this->save_user])
            ->andFilterWhere(['like', 'out_user', $this->out_user])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'contact', $this->contact])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'relation', $this->relation]);

        return $dataProvider;
    }
}
